<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidateTemail implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Check if the email is in the correct format
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $fail('The ' . $attribute . ' must be a valid email address.');
            return;
        }

        // Check if the email domain is a .edu or .ac.uk domain
        $domain = explode('@', $value)[1];
        if (!in_array(substr($domain, -4), ['.edu', '.ac.uk'])) {
            $fail('The ' . $attribute . ' must be a valid .edu or .ac.uk email address.');
            return;
        }
    }
}