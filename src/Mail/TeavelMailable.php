<?php

namespace Azzarip\Teavel\Mail;

use Illuminate\Mail\Mailable;
use Azzarip\Teavel\Models\Contact;
use Illuminate\Support\Facades\App;

class TeavelMailable extends Mailable
{
    protected $filename;

    protected $content;
    
    protected array $data = [];

    public function __construct(protected Contact $contact) {
        $locale = App::getLocale() ?? 'en';
        $path = __DIR__ . "/../../content/emails/$locale/{$this->filename}.md";
        $this->content = new EmailContent($path, $this->contact, $this->data);
    }

    protected function loadContent() {
        $this->subject = $this->content->subject;
        $this->html = $this->content->html;
        $this->to($this->content->getAddress());
    }

}
