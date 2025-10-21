<?php

namespace App\Domain\Exceptions;

use Exception;

class ServiceException extends Exception
{
    public function __construct(string $message, int $code = 422)
    {
        parent::__construct($message, $code);
    }
}

