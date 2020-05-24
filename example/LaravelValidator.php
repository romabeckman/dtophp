<?php

use \DTOPHP\OutputInterface;
use \DTOPHP\ValidatorInterface;
use \Illuminate\Support\Facades\Response;
use \Illuminate\Support\Facades\Validator;

/**
 * @author Romário Beckman
 */
class LaravelValidator implements ValidatorInterface {

    /**
     * @param OutputInterface $dto
     * @param array $rules
     * @return void
     */
    public function handlerDtoValidator(OutputInterface $dto, array $rules): void {
        $validator = Validator::make($dto->toArray(), $rules);

        if ($validator->fails()) {
            Response::make()
                    ->create($validator->errors()->all(), 400)
                    ->send();
            exit;
        }
    }

}
