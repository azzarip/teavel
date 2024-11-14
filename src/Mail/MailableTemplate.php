<?php

namespace Azzarip\Teavel\Mail;

use Illuminate\Mail\Mailable;
use Azzarip\Teavel\Models\Contact;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;

class MailableTemplate
{
    protected $filename;
    
    protected array $data = [];



    public function __construct(protected Contact $contact)
    {
        //
    }

    public static function to(Contact $contact) {
        return new self($contact);
    }

    protected function loadData() {

    }

    public function send() {
        $locale = App::getLocale() ?? 'en';
        $path = __DIR__ . "/../../content/emails/{$locale}/{$this->filename}.md";

        $this->loadData();

        $content = new EmailContent($path, $this->contact, $this->data);
        
        Mail::send(new TeavelMail($content));
    }
}
