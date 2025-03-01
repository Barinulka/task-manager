<?php

namespace App\Exception;

class ApiValidationException extends BaseApiException
{
    public function __construct(
        string $message = "Ошибка валидации",
        int $code = 400,
        array $data = [],
        ?Throwable $previous = null
    )
    {
        parent::__construct($message, $code, $data, $previous);
    }
}