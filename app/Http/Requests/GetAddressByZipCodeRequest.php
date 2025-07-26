<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetAddressByZipCodeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'zip_code' => ['required', 'string', 'min:8', 'max:8']
        ];
    }

    /**
     * Prepare the data for validation.
     */
    public function prepareForValidation(): void
    {
        $this->merge([
            'zip_code' => preg_replace('/[^0-9]/is', '', $this->zip_code),
        ]);
    }
}
