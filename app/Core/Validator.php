<?php

namespace App\Core;

use DateTime;

final class Validator {

    public static function validate (array $params, array $validationRules) {
        $response = [];
        foreach ($validationRules as $field => $rules) {
            $dataField = self::getDataField($rules);
              
            foreach (explode('|', $rules) as $rule) {
                if ($rule == 'required' && array_key_exists($field, $params) == false) {
                    $response[$field] = "The " . $field ." field is required";
                }
                if (array_key_exists($field, $params) == true){
                    if ($rule == 'email' && filter_var($params[$field], FILTER_VALIDATE_EMAIL) == false) {
                        $response[$field] = "The value of " . $field . " field is not a valid email value";
                    }
                    if ($rule == 'datetime'){
                        if(array_key_exists($field, $params) == false) {
                            $response[$field] = "The value of " . $field . " field is not a valid email value";
                        } else {
                            $format = $_ENV['DATE_TIME_FORMAR'];
                            $dateTime = DateTime::createFromFormat($format, $params[$field]);
                            if(!$dateTime || $dateTime->format($format) !== $params[$field]) {
                                $response[$field] = "The value of " . $field . " field is wrong date format";
                            }
                        }
                    }
                }
            }
        }
        return $response;
    }
    
    public static function getDataField ($rules) {
        $explode = explode('.', $field);
        $count = count($explode);
        if($count > 1) {
            exit(print_r($count, true));
        }
    }
}