<?php

namespace App\Http\Requests\Supplier;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSupplierRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $supplierId = $this->route('id');

        return [
            'name'    => ['required', 'string', 'max:255'],
            'phone'   => ['required', 'string', 'max:20', Rule::unique('suppliers', 'phone')->ignore($supplierId)],
            'email'   => ['nullable', 'email', Rule::unique('suppliers', 'email')->ignore($supplierId)],
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
