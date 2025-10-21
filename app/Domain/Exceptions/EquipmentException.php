<?php

namespace App\Domain\Exceptions;

use Exception;

class EquipmentException extends Exception
{
    public function __construct(string $message, int $code = 422)
    {
        parent::__construct($message, $code);
    }
}