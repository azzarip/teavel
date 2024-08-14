<?php

namespace Azzarip\Teavel\Automations;

use Azzarip\Teavel\Models\Contact;

class  EmailAutomation extends GoalAutomation
{
    const TRANSACTIONAL = false;

    public static function getContentPath() {
        $path = app_path(str_replace('App\\', '/', self::class));
        $file = str_replace(app_path('Teavel\Emails'), base_path('content\emails'), $path) . '.md';
        return $file;
    }


}
