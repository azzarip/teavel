<?php

namespace Azzarip\Teavel\Mail;

use Illuminate\Mail\Mailable;
use Azzarip\Teavel\Models\Contact;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;

class TeavelMailable
{
    protected $filename;

    protected $content;
    
    protected array $data = [];

    public function __construct(protected Contact $contact) {

    }

    public function send() {
        $locale = App::getLocale() ?? 'en';
        $path = __DIR__ . "/../../content/emails/{$locale}/{$this->filename}.md";
        $content = new EmailContent($path, $this->contact, $this->data);
        Mail::html($content->html, function ($message) use ($content) {
            $message->to($content->getAddress())
                    ->subject($content->subject);
        });
    }
}
