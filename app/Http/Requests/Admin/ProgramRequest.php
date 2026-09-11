<?php

namespace App\Http\Requests\Admin;

use App\Enums\ProgramCategory;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProgramRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', Rule::enum(ProgramCategory::class)],
            'description' => ['required', 'string', 'max:2000'],
            'order' => ['nullable', 'integer', 'min:0'],
            'published' => ['sometimes', 'boolean'],
        ];
    }
}
