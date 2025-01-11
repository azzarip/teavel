<?php

namespace Azzarip\Teavel\Automations;

use Azzarip\Teavel\Models\Contact;

class  EmailAutomation extends GoalAutomation
{
    const TRANSACTIONAL = false;

    protected $utm_campaign;
    protected $utm_content;

    public static function getContentPath() {
        $path = app_path(str_replace('App\\', '', get_called_class()));
        $file = str_replace(app_path('Teavel/Emails'), base_path('content/emails'), $path) . '.md';
        return $file;
    }

    protected function getUtms()
    {
        return [
            'utm_source' => 'crm',
            'utm_medium' => 'email',
            'utm_campaign' => $this->utm_campaign,
            'utm_content' => $this->utm_content,
        ];
    }

}
