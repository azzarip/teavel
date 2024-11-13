<?php

namespace Azzarip\Teavel\Mail;

use Illuminate\Mail\Mailable;
use Azzarip\Teavel\Models\Contact;
use Illuminate\Support\Facades\App;

class TeavelMailable extends Mailable
{
    protected $filename;

    protected Contact $contact;
    protected $content;
    
    protected array $data = [];

    protected function getContent() {
        $locale = App::getLocale() ?? 'en';
        $path = __DIR__ . "/../../content/emails/$locale/{$this->filename}.md";
        return new EmailContent($path, $this->contact, $this->data);
    }

}
