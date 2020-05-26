<?php

namespace App\Exceptions;

use Exception;

class ErrorCodeException extends Exception
{
    private $data;

    public function __construct($code, $message = null, $data = null){
        $this->data = $data;
        parent::__construct($message, $code);
    }

    public function getData(){
        return $this->data;
    }
}