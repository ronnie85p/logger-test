<?php

namespace App\Packages\Logger\Exceptions;

class HttpException extends \Exception
{
    private $messages = [
        503 => 'Service Unavailable',
        404 => 'Not found',
    ];

    public function __construct(int $code, string $message = '')
    {
        $message = empty($message) ? $this->messages[$code] : $message;
        $message = empty($message) ? 'Http was failure!' : $message; 

        parent::__construct($message, $code);
    }
}