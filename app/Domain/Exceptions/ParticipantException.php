<?php

namespace App\Domain\Exceptions;

use Exception;

class ParticipantException extends Exception
{
    public function __construct(string $message, int $code = 422)
    {
        parent::__construct($message, $code);
    }
}