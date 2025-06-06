<?php

namespace Azzarip\Teavel\Automations;

use Azzarip\Teavel\Models\Email;
use Azzarip\Teavel\Models\Contact;

class EmailAutomation extends GoalAutomation
{
    const TRANSACTIONAL = false;

    protected $utm_campaign;

    protected $utm_content;

    public static function getContentPath()
    {
        $path = app_path(str_replace('App\\', '', get_called_class()));
        $file = str_replace(app_path('Teavel\Emails'), base_path('content\emails'), $path) . '.md';

        return str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $file);
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

    protected function stopParentSequence()
    {
        $this->email->sequence->stop($this->contact);
    }
    public function __construct(public Contact $contact, public Email $email) {}
}
