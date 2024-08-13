<?php

namespace Azzarip\Teavel\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Azzarip\Teavel\Models\Email;
use Azzarip\Teavel\Models\Contact;
use Illuminate\Support\Facades\Blade;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;

class TeavelMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public string $url;

    protected string $emailUuid;

    protected string $body;

    /**
     * Create a new message instance.
     */
    public function __construct(public Contact $contact, Email $email)
    {
        $content = $email->getContent();
        $this->subject = $this->parseText($content->subject);
        $this->url = $this->getClickUrl();
    
        $this->body = $content->getBody();

    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            to: [new Address($this->contact->email, $this->contact->full_name)],
            subject: $this->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            htmlString: $this->getHtml(),
        );
    }






    protected function parseText($text)
    {
        $text = str_replace('{FIRST_NAME}', $this->contact->first_name, $text);
        $text = str_replace('{LAST_NAME}', $this->contact->last_name, $text);
        $text = str_replace('{FULL_NAME}', $this->contact->full_name, $text);
        $text = str_replace('{EMAIL}', $this->contact->email, $text);
        $text = str_replace('{UUID}', $this->contact->uuid, $text);
        $text = str_replace('{FOOTER_DATE}', $this->contact->marketing_at->format(trans('teavel::email.footer_date')), $text);

        return $text;
    }


}
