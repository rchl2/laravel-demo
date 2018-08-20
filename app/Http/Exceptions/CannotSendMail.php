<?php

namespace App\Http\Exceptions;

final class CannotSendMail extends \Exception
{
    public static function exception(): self
    {
        return new self('Cannot send mail! Check mail config in env file.');
    }
}
