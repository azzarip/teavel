<?php

namespace Azzarip\Teavel\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Azzarip\Teavel\EmailContent;
use Azzarip\Teavel\Models\Email;
use Azzarip\Teavel\Models\Contact;
use Illuminate\Support\Facades\Cache;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class TeavelMail extends Mailable
{
    use Queueable, SerializesModels;

    public EmailContent $emailContent;
    /**
     * Create a new message instance.
     */
    public function __construct(public Contact $contact, $email)
    {
        $this->emailContent = Cache::remember($email->emailFile->file, 910, function () use ($email) {
            return $email->getContent();
        });
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            to: [new Address($this->contact->email, $this->contact->full_name)],
            subject: $this->getSubject(),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'teavel::email.mail',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }


    protected function getUnsubscribeLink()
    {
        return url("/emails/{$this->contact->uuid}/unsubscribe/{$this->email->uuid}");
    }

    protected function getSubject()
    {
        $subject = $this->emailContent->subject;
        return $this->parseText($subject);
    }

    protected function parseText($text)
    {
        $text = str_replace('{FIRST_NAME}', $this->contact->firstName, $text);
        $text = str_replace('{LAST_NAME}', $this->contact->lastName, $text);
        $text = str_replace('{FULL_NAME}', $this->contact->fullName, $text);
        $text = str_replace('{EMAIL}', $this->contact->email, $text);
        $text = str_replace('{UUID}', $this->contact->uuid, $text);
        return $text;
    }
}
