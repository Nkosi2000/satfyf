<?php

namespace App\Http\Requests;

use App\Rules\NotDisposableEmail;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreContactSubmissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Strip any HTML out of the free-text fields before validation — these
     * are plain-text inputs with no legitimate reason to contain markup,
     * and admins read submissions in a context (the admin list/show views)
     * that's already safe via Blade's escaping, but stripping at the door
     * means no raw HTML/script tags ever reach the database at all.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'name' => strip_tags((string) $this->input('name')),
            'subject' => $this->filled('subject') ? strip_tags((string) $this->input('subject')) : null,
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', new NotDisposableEmail],
            'phone' => ['nullable', 'string', 'max:50'],
            'subject' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
        ];
    }
}
