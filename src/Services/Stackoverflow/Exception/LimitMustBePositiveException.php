<?php

declare(strict_types=1);

namespace App\Services\Stackoverflow\Exception;

class LimitMustBePositiveException extends \Exception
{

    public function __construct($message, $code = 400, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}