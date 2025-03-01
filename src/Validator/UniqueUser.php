<?php

namespace App\Validator;

use App\Validator\User\UniqueUserValidator;
use Symfony\Component\Validator\Attribute\HasNamedArguments;
use Symfony\Component\Validator\Constraint;

#[\Attribute]
final class UniqueUser extends Constraint
{
    public ?string $message = '{{ value }} уже используется.';
    public ?string $field;

    // You can use #[HasNamedArguments] to make some constraint options required.
    // All configurable options must be passed to the constructor.
    #[HasNamedArguments]
    public function __construct(
        string $message = null,
        string $field = null,
        ?array $groups = null,
        mixed $payload = null
    ) {
        parent::__construct([], $groups, $payload);
        $this->message = $message ?? $this->message;
        $this->field = $field ?? $this->field;
    }


    public function validatedBy(): string
    {
        return UniqueUserValidator::class;
    }
}
