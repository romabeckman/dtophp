<?php

use \Dtophp\Validation\ValidatorAbstract;
use \Illuminate\Support\Facades\Response;
use \Illuminate\Support\Facades\Validator;

/**
 * @author Romário Beckman
 */
class LaravelValidator extends ValidatorAbstract {

    public function handler(): void {
        $validator = Validator::make(parent::getDto()->toArray(), parent::getRules());

        if ($validator->fails()) {
            Response::make()
                    ->create($validator->errors()->all(), 400)
                    ->send();
            exit;
        }
    }

}
