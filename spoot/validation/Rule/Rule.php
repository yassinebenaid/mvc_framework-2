<?php

namespace Spoot\Validation\Rule;

abstract class Rule
{
    abstract public function validate(array $data, string $field,  $param = null);
    abstract public function getMessage(array $data, string $field,  $param = null): string;
}
