<?php

namespace Core\Exception;

class FilterException extends \Exception
{
    
    public function __construct(array $message, $code = 400)
    {
        parent::__construct(json_encode($message), $code);
    }

    public function getArrayMessages()
    {
        return json_decode($this->message);
    }

}
