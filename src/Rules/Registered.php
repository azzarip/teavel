<?php

namespace Azzarip\Teavel\Rules;

use Illuminate\Translation\PotentiallyTranslatedString;
use Azzarip\Teavel\Models\Contact;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Registered implements ValidationRule
{
    public static function handle(): string
    {
        return 'registered';
    }

    /**
     * Run the validation rule.
     *
     * @param Closure(string):PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $contact = Contact::findEmail($value);

        if ($contact && $contact->is_registered) {
            $fail('registered');
        }
    }
}
