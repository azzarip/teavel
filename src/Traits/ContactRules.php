<?php

namespace Azzarip\Teavel\Traits;

trait ContactRules
{
    protected function contactRules()
    {
        return [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email',
            'privacy' => 'accepted',
            'phone' => 'required|phone',
        ];
    }
}
