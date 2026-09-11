<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Concerns\ValidatesTranslatable;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ResourceRequest extends FormRequest
{
    use ValidatesTranslatable;

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
            ...$this->translatableRules('title', ['string', 'max:255']),
            ...$this->translatableRules('description', ['string', 'max:1000'], required: false),
            'file' => [$this->isMethod('post') ? 'required' : 'nullable', 'file', 'max:20480'],
            ...$this->translatableRules('category', ['string', 'max:100'], required: false),
            'published' => ['sometimes', 'boolean'],
        ];
    }
}
