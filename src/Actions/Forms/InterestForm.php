<?php

namespace Azzarip\Teavel\Actions\Forms;

use Azzarip\Teavel\Jobs\CompleteForm;
use Azzarip\Teavel\Models\Contact;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class InterestForm
{
    public static function achieve(string $form, string $slug)
    {
        $contact = Auth::check() ? Auth::user() : Contact::fromSession();
        
        if(empty($contact)) return;

        $key = "form.{$slug}.{$contact->id}";
        if (! Cache::has($key)) {
            Cache::put($key, true, now()->addHours(2));

            CompleteForm::dispatchAfterResponse($contact, $form);

            return true;
        }
        return false;
    }
}