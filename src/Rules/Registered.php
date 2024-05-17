<?php

namespace Azzarip\Teavel\Rules;

use Closure;
use Azzarip\Teavel\Models\Contact;
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
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $contact = Contact::findEmail($value);

        if ($contact && $contact->is_registered) {
            $fail('registered');
        }
    }
}
