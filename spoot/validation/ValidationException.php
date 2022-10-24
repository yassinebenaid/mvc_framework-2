<?php

namespace Spoot\Validation;

use InvalidArgumentException;

class ValidationException extends InvalidArgumentException
{
    protected array $errors;

    public function __construct(array $errors)
    {
        $this->errors = $errors;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
