<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\Validation\ValidationService;
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

abstract class BasicAbstractController extends AbstractController
{
    private const SUPPORTED_CONTENT_TYPES = [
        'application/json'
    ];

    public static function getSubscribedServices(): array
    {
        $subscribedServices = parent::getSubscribedServices();

        return array_merge($subscribedServices, [
            'app.validation_service' => '?'.ValidationService::class,
        ]);
    }

    /**
     * Форматирование данных из запроса в массив
     *
     * @param Request $request
     * @return array
     * @throws RuntimeException
     */
    protected function getRequestArrayData(Request $request): array
    {
        if (!$this->isValidContentTypeInRequest($request)) {
            throw new RuntimeException('Неподдерживаемый тип содержимого');
        }

        if ($request->request->all()) {
            return $request->request->all();
        }

        $content = file_get_contents('php://input');
        if ($content === false) {
            throw new RuntimeException('Ошибка чтения входных данных');
        }

        $data = json_decode($content, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new RuntimeException('Ошибка при парсинге JSON');
        }

        return $data ?? [];
    }

    private function isValidContentTypeInRequest(Request $request): bool
    {
        $contentType = $this->getContentType($request);

        return in_array($contentType, self::SUPPORTED_CONTENT_TYPES, true);
    }

    private function getContentType(Request $request): string
    {
        return strtolower($request->headers->get('Content-Type'));
    }
}
