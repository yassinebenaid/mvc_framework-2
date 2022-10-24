<?php

namespace Spoot\Validation\Rule;

class EmailRule extends Rule
{
    public function validate(array $data, string $field,  $param = null)
    {
        if (empty($data[$field])) {
            return true;
        }

        return preg_match("#^([\w]+)@([\w]+)(\.([\w]+))+$#", $data[$field]);
    }

    public function getMessage(array $data, string $field,  $param = null): string
    {
        return "$field must be a valid email adress ! ";
    }
}
