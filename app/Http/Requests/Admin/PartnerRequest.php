<?php

namespace App\Http\Requests\Admin;

use App\Enums\PartnerType;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PartnerRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'logo' => ['nullable', 'image', 'max:4096'],
            'url' => ['nullable', 'url', 'max:255'],
            'type' => ['required', Rule::enum(PartnerType::class)],
            'order' => ['nullable', 'integer', 'min:0'],
            'published' => ['sometimes', 'boolean'],
        ];
    }
}
