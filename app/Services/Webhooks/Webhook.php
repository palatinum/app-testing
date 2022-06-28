<?php

namespace App\Services\Webhooks;

use App\Core\Validator;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class Webhook {
    public $data;
    public $dataRules;
    
    public function __construct(array $request) {
        $this->data = $request['data'] ?? null;
    }
    
    public function validateData () {
        $fails = Validator::validate($this->data, $this->dataRules);
        if(!empty($fails)) {
            throw new BadRequestException(json_encode($fails), 400);
        }
    }
}
