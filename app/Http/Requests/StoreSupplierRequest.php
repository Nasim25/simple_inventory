<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSupplierRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'    => ['required', 'string', 'max:255'],
            'phone'   => ['required', 'string', 'max:20', 'unique:suppliers,phone'],
            'email'   => ['nullable', 'email', 'unique:suppliers,email'],
            'address' => ['nullable', 'string'],
            'status'  => ['required', 'boolean']
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'   => 'The name is required.',
            'phone.required'  => 'The phone number is required.',
            'phone.unique'    => 'This phone number is already taken.',
            'email.email'     => 'Enter a valid email address.',
            'status.required' => 'Status is required.'
        ];
    }
}
