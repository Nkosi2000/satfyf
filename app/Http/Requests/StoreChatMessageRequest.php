<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreChatMessageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Strip HTML before the message ever reaches the Claude API or gets
     * stored — plain conversational text has no legitimate use for markup.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'message' => strip_tags((string) $this->input('message')),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'message' => ['required', 'string', 'max:1000'],
            'conversation_id' => ['nullable', 'uuid', 'exists:chat_conversations,id'],
        ];
    }
}
