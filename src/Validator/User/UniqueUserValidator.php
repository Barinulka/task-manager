<?php

namespace App\Validator\User;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Validator\UniqueUser;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use http\Exception\InvalidArgumentException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

final class UniqueUserValidator extends ConstraintValidator
{

    private EntityRepository $repository;

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {
        $this->repository = $this->entityManager->getRepository(User::class);
    }

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof UniqueUser) {
            throw new UnexpectedTypeException($constraint, UniqueUser::class);
        }

        if ($this->isFieldExists($constraint->field, $value)) {
            $this->buildViolation($constraint, $value);
        }
    }

    private function isFieldExists(string $field, string $value): bool
    {
        return (bool) $this->repository->findOneBy([$field => $value]);
    }

    private function buildViolation(Constraint $constraint, string $value): void
    {
        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ value }}', $value)
            ->addViolation();
    }

}
