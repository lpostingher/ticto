<?php

namespace App\Http\Requests;

use App\Rules\TaxvatNumberRule;

class UpdateUserRequest extends StoreUserRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            'taxvat_number' => [
                'required',
                'string',
                new TaxvatNumberRule(),
                'unique:users,taxvat_number,' . $this->id
            ],
            'email' => ['required', 'email', 'unique:users,email,' . $this->id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);
    }
}
