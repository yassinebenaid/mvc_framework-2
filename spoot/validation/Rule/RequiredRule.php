<?php

namespace Spoot\Validation\Rule;

class RequiredRule extends Rule
{
    public function validate(array $data, string $field,  $param = null)
    {
        return empty($data[$field]) ? false : true;
    }

    public function getMessage(array $data, string $field, $param = null): string
    {
        return "$field is required !";
    }
}
