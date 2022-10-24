<?php

namespace Spoot\Validation\Rule;


use InvalidArgumentException;

class MinRule extends Rule
{
    public function validate(array $data, string $field,  $param = null)
    {
        if (empty($data[$field])) {
            return true;
        }
        if (is_null($param)) throw new InvalidArgumentException("min lenght  isn't defined !");

        return strlen($data[$field]) >= $param;
    }

    public function getMessage(array $data, string $field, $param = null): string
    {
        return "$field must be at least $param characters !";
    }
}
