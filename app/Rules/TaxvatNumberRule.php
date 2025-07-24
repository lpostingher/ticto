<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class TaxvatNumberRule implements ValidationRule
{
    private const ERROR_MESSAGE = 'CPF inválido';

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $taxvat = preg_replace('/[^0-9]/is', '', $value);

        if (strlen($taxvat) != 11) {
            $fail(self::ERROR_MESSAGE);
        }

        if (preg_match('/(\d)\1{10}/', $taxvat)) {
            $fail(self::ERROR_MESSAGE);
        }

        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $taxvat[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($taxvat[$c] != $d) {
                $fail(self::ERROR_MESSAGE);
            }
        }
    }
}
