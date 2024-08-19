<?php

namespace Azzarip\Teavel\Mail;

use Twig\Environment;
use Twig\Loader\ArrayLoader;
use Illuminate\Mail\Mailable;
use Azzarip\Teavel\Models\Contact;
use Illuminate\Support\Facades\App;
use Illuminate\Mail\Mailables\Address;

class TeavelMailable extends Mailable
{
    protected $filename;

    protected Contact $contact;

    protected array $data;


    public function toContact(Contact $contact) {
        $this->contact = $contact;

        $content = new EmailContent($this->getFilename());

        $this->subject = $content->subject;

        $this->to(new Address($this->contact->email, $this->contact->full_name));
        $this->html = $this->parseEmail($content->html);

        return $this;
    }

    protected function getFilename() {
        $locale = App::getLocale() ?? 'en';
        return __DIR__ . "/../../content/emails/$locale/{$this->filename}.md";
    }

    protected function parseEmail($email)
    {
        $loader = new ArrayLoader(['email' => $email]);
        $twig = new Environment($loader, ['autoescape' => false]);

        $html = $twig->render('email', [
            'contact' => $this->contact,
        ] + $this->data);

        return $html;
    }

}
