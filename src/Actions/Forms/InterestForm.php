<?php

namespace Azzarip\Teavel\Actions\Forms;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class InterestForm
{
    public static function achieve(string $form, string $slug)
    {
        $contact = Auth::user();
        
        if(empty($contact)) return;

        $key = "form.{$slug}.{$contact->id}";
        if (! Cache::has($key)) {
            $contact->completeForm($form);
            Cache::put($key, true, now()->addHours(2));
            return true;
        }
        return false;
    }
}