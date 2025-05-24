<?php

namespace App\Rules;

use Closure;
// use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Rule;

// class Base64Image implements ValidationRule
class Base64Image implements Rule
{
    // /**
    //  * Run the validation rule.
    //  *
    //  * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
    //  */
    // public function validate(string $attribute, mixed $value, Closure $fail): void
    // {
    //     //
    // }
    public function passes($attribute, $value)
    {
        if (!preg_match('/^data:image\/(\w+);base64,/', $value['url'])) {
            return false;
        }

        list($type, $data) = explode(';', $value['url']);
        list(, $data)      = explode(',', $data);

        if (!in_array($type, ['data:image/png', 'data:image/jpeg', 'data:image/gif'])) {
            return false;
        }

        if (strlen(base64_decode($data)) > 2 * 1024 * 1024) {
            return false;
        }

        return true;
    }

    public function message()
    {
        return 'The :attribute must be a valid base64 encoded image (PNG, JPEG, GIF) with a maximum size of 2MB.';
    }
}
