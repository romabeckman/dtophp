<?php

namespace DTOPHP;

use \DTOPHP\Configuration;
use \DTOPHP\Exception\DtoException;
use \DTOPHP\Helpers\Util;
use \DTOPHP\OutputInterface;
use \DTOPHP\Parameter\FixedByDocComment;
use \DTOPHP\Parameter\FixedByReflectorType;
use \DTOPHP\Parameter\GetDirectFromData;
use \DTOPHP\Parameter\InDtoClass;
use \DTOPHP\Parameter\ParameterNotExistInData;
use \ReflectionClass;

/**
 * This class populate data by Body HTTP.
 *
 * The __construct is not allowed to overwrite. For populate data, there must have exists "set" methods.
 * Only one parameter will be accepted for "set" methods.
 *
 * @author Romário Beckman <romabeckman@gmail.com>
 */
abstract class InDto implements OutputInterface {

    use OutputTrait;

    /**
     *
     * @param string|null $_
     */
    final public function __construct(?array $_ = null) {
        $this->handler(is_null($_) ? Util::getData() : $_);
    }

    /**
     * @throws DtoException
     */
    private function handler(?array $data) {
        $validatorEngine = Configuration::getValidatorEngine();
        $reflection = new ReflectionClass(static::class);
        $rules = [];

        foreach ($reflection->getProperties() as $property) {
            if (is_null($validatorEngine) === false && $rule = Util::attributeDocComment($property->getDocComment(), 'rule')) {
                $rules[$property->getName()] = $rule;
            }

            $parameter = new ParameterNotExistInData;
            $parameter
                    ->setNext(new InDtoClass)
                    ->setNext(new FixedByReflectorType)
                    ->setNext(new FixedByDocComment)
                    ->setNext(new GetDirectFromData);

            $value = $parameter->handle($property, $data);

            if (is_null($value) === false) {
                $property->setAccessible(true);
                $property->setValue($this, $value);
            }
        }

        // Call validator
        empty($rules) || (new $validatorEngine())->handlerDtoValidator($this, $rules);
    }

}
