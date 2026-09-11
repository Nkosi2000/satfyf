<?php

namespace App\Http\Requests\Concerns;

trait ValidatesTranslatable
{
    /**
     * Validation rules for a translatable field: the field itself plus its
     * four locale sub-keys. English is required when $required is true;
     * isiZulu, Sesotho, and Afrikaans are always optional so content can be
     * translated incrementally.
     *
     * @param  array<int, mixed>  $rules
     * @return array<string, array<int, mixed>>
     */
    protected function translatableRules(string $field, array $rules, bool $required = true): array
    {
        return [
            $field => [$required ? 'required' : 'nullable', 'array'],
            "$field.en" => [$required ? 'required' : 'nullable', ...$rules],
            "$field.zu" => ['nullable', ...$rules],
            "$field.st" => ['nullable', ...$rules],
            "$field.af" => ['nullable', ...$rules],
        ];
    }
}
