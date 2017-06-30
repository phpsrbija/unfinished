<?php

declare(strict_types=1);

namespace Std;

class FilterException extends \Exception
{
    /**
     * FilterException constructor.
     *
     * @param array $message
     * @param int   $code
     */
    public function __construct(array $message, $code = 400)
    {
        parent::__construct(json_encode($message), $code);
    }

    /**
     * @return mixed
     */
    public function getArrayMessages()
    {
        return json_decode($this->message);
    }
}
