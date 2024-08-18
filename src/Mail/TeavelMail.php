<?php

namespace Azzarip\Teavel\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Azzarip\Teavel\Models\Contact;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;

class TeavelMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(public Contact $contact, string $filename, protected array $data = [])
    {
        $content = new EmailContent($filename);

        $this->subject = $content->subject;

        $this->html = $this->parseText($content->html);
    }


    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            to: [new Address($this->contact->email, $this->contact->full_name)],
        );
    }


    protected function parseText($text)
    {
        $loader = new \Twig\Loader\ArrayLoader(['email' => $text]);
        $twig = new \Twig\Environment($loader, ['autoescape' => false]);

        $html = $twig->render('email', [
            'contact' => $this->contact,
        ] + $this->data);

        return $html;
    }


}
