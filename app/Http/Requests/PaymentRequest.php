<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PaymentRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'client_profile_id' => ['required', 'integer', 'exists:client_profiles,id'],
            'amount'  => ['nullable', 'numeric', 'min:0'], // nullable => auto-calc allowed
            'status'  => ['nullable', Rule::in(['pending', 'paid', 'failed'])],
            'method'  => ['nullable', Rule::in(['card', 'cash', 'bank_transfer'])],
            'paid_at' => ['nullable', 'date'],
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'status' => $this->input('status', 'paid'),
            'method' => $this->input('method', 'cash'),
        ]);
    }
}
