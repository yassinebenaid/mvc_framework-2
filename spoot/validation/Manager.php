<?php

namespace Spoot\Validation;

use Spoot\Validation\Rule\Rule;

class Manager
{
    protected array $rules = [];

    public function addRule(string $alias, Rule $rule)
    {
        $this->rules[$alias] = $rule;
    }

    public function validate(array $data, array $rules)
    {
        $errors = [];

        foreach ($rules as $field => $rulesForField) {
            foreach ($rulesForField as $rule) {
                $ruleName = $rule;
                $param = null;

                if (str_contains($rule, ":")) {
                    [$ruleName, $param] = explode(':', $rule);
                }

                $proccessor = $this->rules[$ruleName];

                if (!$proccessor->validate($data, $field, $param)) {
                    $errors[$field] = $proccessor->getMessage($data, $field, $param);
                }
            }
        }

        if (count($errors) > 0) {
            throw new ValidationException($errors);
        }

        return array_intersect_key($data, $rules);
    }
}
