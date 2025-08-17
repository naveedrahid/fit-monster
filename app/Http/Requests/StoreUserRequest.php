<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
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
        $rules = [
            'shift_id' => ['required', 'exists:shifts,id'],
            'name'     => ['required', 'string', 'max:255'],
            'age'      => ['required', 'numeric', 'min:18', 'max:60'],
            'gender'   => ['required', Rule::in(['male', 'female'])],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'max:20'],
            'roles'    => ['required'],
            'type'     => ['required', Rule::in(['client', 'trainer'])],
            'phone'    => ['required', 'string', 'max:15'],
            'emergency_contact' => ['nullable', 'string', 'max:15'],
        ];

        // Trainer-specific
        if ($this->type === 'trainer') {
            $rules = array_merge($rules, [
                'specialization' => ['required', 'string', 'max:255'],
                'experience'     => ['required', 'integer', 'min:0'],
                'salary'         => ['required', 'numeric', 'min:0'],
            ]);
        }

        // Client-specific
        if ($this->type === 'client') {
            $rules['plan_type'] = ['required', Rule::in(['default', 'custom', 'addon_only'])];

            if (in_array($this->plan_type, ['default', 'custom'])) {
                $rules['package_id'] = ['required', 'exists:packages,id'];
            } else {
                $rules['package_id'] = ['nullable'];
            }

            $rules = array_merge($rules, [
                'height' => ['required', 'numeric', 'min:0'],
                'weight' => ['required', 'numeric', 'min:0'],
                'goal'   => ['required', 'string', 'max:255'],
                'addons'   => ['nullable', 'array'],
                'addons.*' => ['exists:addons,id'],
            ]);
        }

        return $rules;
    }
}
