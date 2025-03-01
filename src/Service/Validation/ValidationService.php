<?php

namespace App\Service\Validation;

use Symfony\Component\Validator\Validator\ValidatorInterface;

class ValidationService extends AbstractValidationService
{
    public function __construct(
        private readonly ValidatorInterface $validator,
    ) {
    }

    public function validate(object $dto): ?array
    {
        $errors = $this->validator->validate($dto);
        return $errors->count() > 0 ? $this->formatErrors($errors) : null;
    }

}