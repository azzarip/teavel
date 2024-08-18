<?php

namespace Azzarip\Teavel\Mail;

use Twig\Environment;
use Twig\Loader\ArrayLoader;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Envelope;
use Azzarip\Teavel\Models\Contact;
use Illuminate\Mail\Mailable;

class TeavelMailable extends Mailable
{
    protected $filename;

    protected Contact $contact;

    protected array $data;


    public function toContact(Contact $contact) {
        $content = new EmailContent($this->getFilename());

        $this->subject = $content->subject;

        $this->html = $this->parseText($content->html);
    }

    protected function getFilename() {
        return base_path() . '/' . $this->filename;
    }


    public function envelope(): Envelope
    {
        return new Envelope(
            to: [new Address($this->contact->email, $this->contact->full_name)],
        );
    }


    protected function parseText($text)
    {
        $loader = new ArrayLoader(['email' => $text]);
        $twig = new Environment($loader, ['autoescape' => false]);

        $html = $twig->render('email', [
            'contact' => $this->contact,
        ] + $this->data);

        return $html;
    }

}
