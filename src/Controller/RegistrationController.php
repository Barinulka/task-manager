<?php

namespace App\Controller;

use App\DTO\User\RegisterDTO;
use App\Exception\ApiValidationException;
use App\Helper\ControllerHelper;
use App\Service\Register\RegisterService;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

final class RegistrationController extends BasicAbstractController
{
    use ControllerHelper;

    public function __construct(
        private EntityManagerInterface $entityManager,
        private RegisterService $service,
    ) {

    }

    #[Route('/api/register', name: 'api_register')]
    public function register(Request $request): JsonResponse
    {
        $requestData = $this->getRequestArrayData($request);

        $registerDto = $this->container->get('serializer')->deserialize($request->getContent(), RegisterDto::class, 'json');

        $errors = $this->container->get('app.validation_service')->validate($registerDto);
        if ($errors) {
            throw new ApiValidationException("Ошибка валидации", Response::HTTP_BAD_REQUEST, $errors);
        }

        $dtoData = $this->service->registerUser($registerDto);

        return new JsonResponse($dtoData->getResponse(), $dtoData->code);
    }
}
