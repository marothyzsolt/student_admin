<?php


namespace App\Traits;


use Symfony\Component\Validator\Validator\ValidatorInterface;

trait Validator
{
    protected function validate($entity, ValidatorInterface $validator)
    {
        $errors = [];
        foreach ($validator->validate($entity) as $index => $item) {
            $errors[] = $item->getMessage();
        }

        return $errors;
    }
}