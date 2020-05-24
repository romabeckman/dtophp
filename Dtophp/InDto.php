<?php

namespace Dtophp;

use \Dtophp\Configuration;
use \Dtophp\Exception\DtoException;
use \Dtophp\Helpers\Output;
use \Dtophp\Helpers\Util;
use \Dtophp\InDto;
use \Dtophp\OutputsInterface;
use \ReflectionClass;
use \ReflectionException;
use \ReflectionParameter;
use \UnexpectedValueException;

/**
 * This class populate data by Body HTTP.
 *
 * The __construct is not allowed to overwrite. For populate data, there must have exists "set" methods.
 * Only one parameter will be accepted for "set" methods.
 *
 * @author Romário Beckman <romabeckman@gmail.com>
 */
abstract class InDto implements OutputsInterface {

    /**
     *
     * @param string|null $_
     */
    final public function __construct(?array $_ = null) {
        $this->handler(is_null($_) ? Util::getData() : $_);
    }

    /**
     *
     * @return string
     */
    final public function toJson(): string {
        return Output::json($this);
    }

    /**
     *
     * @return array
     */
    final public function toArray(): array {
        return Output::array($this);
    }

    /**
     * @return string
     */
    public function __toString(): string {
        return $this->toJson();
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

            $setMethod = 'set' . Util::toPascalCase($property->getName());

            try {
                $reflectionMethod = $reflection->getMethod($setMethod);

                if ($reflectionMethod->getNumberOfParameters() === 0) {
                    throw new DtoException('The "' . $reflectionMethod->getName() . '" method must accept parameter.');
                }

                if (isset($data[$property->getName()])) {
                    $parameter = $reflectionMethod->getParameters()[0];

                    $value = is_null($parameter->getClass()) ?
                            $this->parameter($parameter, $data) :
                            $this->newInClass($parameter, $data);

                    is_null($value) || $reflectionMethod->invoke($this, $value);
                }
            } catch (ReflectionException $exc) {
                throw new DtoException('The "' . $setMethod . '" method not found.');
            }
        }

        // Call validator
        empty($rules) || (new $validatorEngine())->handlerDtoValidator($this, $rules);
    }

    /**
     *
     * @param ReflectionParameter $parameter
     * @return InDto
     * @throws UnexpectedValueException
     */
    private function newInClass(ReflectionParameter $parameter, ?array $data): InDto {
        $reflection = new ReflectionClass($parameter->getClass()->name);

        if (empty($reflection->getParentClass()) || $reflection->getParentClass()->getName() !== InDto::class) {
            throw new UnexpectedValueException('The class "' . $reflection->getName() . '" must extends abstract class "' . InDto::class . '".');
        }

        return $reflection->newInstance($data[$parameter->getName()] ?? []);
    }

    /**
     *
     * @param ReflectionParameter $parameter
     * @param string|null $key
     * @return type
     */
    private function parameter(ReflectionParameter $parameter, ?array $data) {
        $type = $parameter->getType();

        if (is_null($type)) {
            return $data[$parameter->getName()];
        }

        return Util::fixesByType($type, $data[$parameter->getName()]);
    }

}
