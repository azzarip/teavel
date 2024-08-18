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

    /**
     * Create a new message instance.
     */
    public function __construct(public Contact $contact, EmailContent $content, protected array $data = [])
    {
        $this->subject = $content->subject;

        $this->html = $this->parseText($content->html);
    }

    public static function raw(Contact $contact, string $emailPath, array $data = [])
    {
        $email = new EmailContent($emailPath);

        return new static($contact, $email, $data);
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
