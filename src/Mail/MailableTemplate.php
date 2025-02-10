<?php

namespace Azzarip\Teavel\Mail;

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

    public static function to(Contact $contact)
    {
        return new static($contact);
    }

    protected function loadData() {}

    public function send()
    {
        $locale = App::getLocale() ?? 'en';
        $path = __DIR__ . "/../../content/emails/{$locale}/{$this->filename}.md";

        $this->loadData();

        $content = EmailContent::fromFile($path)
            ->to($this->contact)
            ->with($this->data);

        Mail::send(new TeavelMail($content));
    }
}
