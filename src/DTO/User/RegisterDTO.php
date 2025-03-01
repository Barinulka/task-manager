<?php

namespace App\DTO\User;

use App\Validator\UniqueUser;
use Symfony\Component\Validator\Constraints as Assert;

class RegisterDTO
{
    #[Assert\Length(min: 3, max: 180)]
    #[UniqueUser(message: "Логин {{ value }} уже используется", field: "username")]
    public ?string $username = null;

    #[Assert\NotBlank]
    #[Assert\Email]
    #[UniqueUser(message: "Email {{ value }} уже используется", field: "email")]
    public ?string $email = null;

    #[Assert\NotBlank]
    #[Assert\Length(min: 5)]
    #[Assert\Regex(
        pattern: "/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{5,}$/",
        message: "Пароль должен содержать как минимум одну букву и одну цифру и иметь не менее 5 символов"
    )]
    public ?string $password = null;
}