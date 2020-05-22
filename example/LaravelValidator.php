<?php

use \Dtophp\OutputsInterface;
use \Dtophp\Validation\ValidatorInterface;
use \Illuminate\Support\Facades\Response;
use \Illuminate\Support\Facades\Validator;

/**
 * @author Romário Beckman
 */
class LaravelValidator implements ValidatorInterface {

    /**
     * @param OutputsInterface $dto
     * @param array $rules
     * @return void
     */
    public function handlerDtoValidator(OutputsInterface $dto, array $rules): void {
        $validator = Validator::make($dto->toArray(), $rules);

        if ($validator->fails()) {
            Response::make()
                    ->create($validator->errors()->all(), 400)
                    ->send();
            exit;
        }
    }

}
