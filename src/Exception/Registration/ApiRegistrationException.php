<?php

namespace App\Exception\Registration;

use App\Exception\BaseApiException;
use App\Exception\Throwable;
use Symfony\Component\HttpFoundation\Response;

class ApiRegistrationException extends BaseApiException
{
    public function __construct(
        string $message = "Ошибка регистрации. Пожалуйста попробуйте позже.",
        int $code = Response::HTTP_INTERNAL_SERVER_ERROR,
        array $data = [],
        ?Throwable $previous = null
    )
    {
        parent::__construct($message, $code, $data, $previous);
    }
}