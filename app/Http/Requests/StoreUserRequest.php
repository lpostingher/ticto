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
            'taxvat_number' => ['required', 'string', new TaxvatNumberRule, 'unique:users'],
            'email' => ['required', 'email', 'unique:users'],
            'role' => ['required', 'string', new EnumValue(UserRoleEnum::class, false)],
            'birth_date' => ['required', 'date', 'before_or_equal:today'],
            'zip_code' => ['required', 'string', 'min:8', 'max:8'],
            'city_id' => ['required', 'exists:cities,id'],
            'street' => ['required', 'string', 'max:255'],
            'number' => ['required', 'string', 'max:100'],
            'district' => ['required', 'string', 'max:255'],
            'complement' => ['nullable', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    /**
     * Prepare the data for validation.
     */
    public function prepareForValidation(): void
    {
        $this->merge([
            'taxvat_number' => preg_replace('/[^0-9]/is', '', $this->taxvat_number),
            'zip_code' => preg_replace('/[^0-9]/is', '', $this->zip_code),
        ]);
    }
}
