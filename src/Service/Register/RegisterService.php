<?php

namespace App\Service\Register;

use App\DTO\ResponseDTO;
use App\DTO\User\RegisterDTO;
use App\Entity\User;
use App\Exception\Registration\ApiRegistrationException;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    public function registerUser(RegisterDTO $registerDTO): ResponseDTO
    {
        $user = $this->createUser($registerDTO);


        try {
            $this->entityManager->getRepository(User::class)->saveUser($user);
        } catch (\Exception $exception) {
            throw new ApiRegistrationException();
        }

        return new ResponseDTO(true, sprintf('Пользователь %s успешно зарегистрирован', $registerDTO->username), Response::HTTP_CREATED, ['userId' => $user->getId()] );
    }

    private function createUser(RegisterDTO $registerDTO): User
    {
        $user = new User();
        $user->setEmail($registerDTO->email);
        $user->setUsername($registerDTO->username);

        // Подготовка и запись пароля
        $hashedPassword = $this->passwordHasher->hashPassword($user, $registerDTO->password);
        $user->setPassword($hashedPassword);

        return $user;
    }
}

