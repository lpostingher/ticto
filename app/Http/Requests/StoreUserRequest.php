<?php

namespace App\Http\Requests;

use App\Enums\UserRoleEnum;
use App\Rules\Cpf;
use App\Rules\TaxvatNumberRule;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
        return [
            'name' => ['required', 'string', 'max:255'],
            'taxvat_number' => ['required', 'string', new TaxvatNumberRule],
            'email' => ['required', 'email', 'unique:users'],
            'role' => ['required', 'string', new EnumValue(UserRoleEnum::class, false)],
            'birth_date' => ['required', 'date'],
        ];
    }

    /**
     * Prepare the data for validation.
     */
    public function prepareForValidation(): void
    {
        $this->merge([
            'taxvat_number' => preg_replace('/[^0-9]/is', '', $this->taxvat_number),
        ]);
    }
}
