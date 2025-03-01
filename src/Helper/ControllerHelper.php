<?php
namespace App\Helper;

use Symfony\Component\Validator\ConstraintViolationList;

trait ControllerHelper 
{
    public function formatValidateErrors(ConstraintViolationList $errors): array
    {
        $errorMessages = [];

        foreach ($errors as $error) {
            $errorMessages[$error->getPropertyPath()] = $error->getMessage();
        }


        return $errorMessages;
    }
}