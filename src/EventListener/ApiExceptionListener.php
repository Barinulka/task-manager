<?php

namespace App\EventListener;

use App\Exception\BaseApiException;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\KernelEvents;

final class ApiExceptionListener
{
    public function __construct(
        protected LoggerInterface $logger
    ) {
    }

    #[AsEventListener(event: KernelEvents::EXCEPTION)]
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        $responseData = [
            "status" => "error",
            "message" => $exception->getMessage(),
        ];

        if ($exception instanceof BaseApiException) {
            if ($exception->getData()) {
                $responseData["data"] = $exception->getData();
            }
            $statusCode = $exception->getCode();
        } else {
            $statusCode = $exception instanceof HttpExceptionInterface ? $exception->getStatusCode() : Response::HTTP_INTERNAL_SERVER_ERROR;
            $responseData["message"] = $exception->getMessage() ?? "Произошла непредвиденная ошибка";
        }

        $this->logger->error(json_encode($responseData));

        $event->setResponse(new JsonResponse($responseData, $statusCode));
    }
}
