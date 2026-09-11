<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class GalleryImageRequest extends FormRequest
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
            'caption' => ['nullable', 'string', 'max:255'],
            'image' => [$this->isMethod('post') ? 'required' : 'nullable', 'image', 'max:8192'],
            'category' => ['nullable', 'string', 'max:100'],
            'order' => ['nullable', 'integer', 'min:0'],
        ];
    }
}
