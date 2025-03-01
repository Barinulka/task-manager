<?php

namespace App\Service\Validation;

use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class AbstractValidationService
{

    protected array $errors = [];

    protected function formatErrors(?ConstraintViolationListInterface $violations): array
    {
        if (!is_null($violations)) {
            foreach ($violations as $violation) {
               $this->errors[$violation->getPropertyPath()] = $violation->getMessage();
            }
        }

        return $this->errors;
    }

    abstract public function validate(object $dto): ?array;
}