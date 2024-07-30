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

    public array $parts;
    public string $unsubscribeLink;
    public array $cta;

    /**
     * Create a new message instance.
     */
    public function __construct(public Contact $contact, Email $email)
    {
        $emailContent = Cache::remember($email->emailFile->file, 910, function () use ($email) {
            return $email->getContent();
        });

        $this->parts = array_map([$this, 'parseText'], $emailContent->parts);
        $this->cta = $emailContent->ctas;
        $this->cta = $this->redactUrls($email);

        $this->subject = $this->getSubject($emailContent);
        $this->unsubscribeLink = $this->getUnsubscribeLink($email);
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
            markdown: 'teavel::email.mail',
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


    protected function getUnsubscribeLink(Email $email)
    {
        return url("/emails/{$this->contact->uuid}/unsubscribe/{$email->uuid}");
    }

    protected function getSubject($emailContent)
    {
        $subject = $emailContent->subject;
        return $this->parseText($subject);
    }

    protected function redactUrls(Email $email)
    {
        $num = 0;
        $ctas = $this->cta;
        foreach ($ctas as $cta) {
            $cta['link'] = url("/emails/{$email->uuid}/clrd/{$num}/{$this->contact->uuid}");
            $num++;
        }
        return $ctas;
    }

    protected function parseText($text)
    {
        $text = str_replace('{FIRST_NAME}', $this->contact->first_name, $text);
        $text = str_replace('{LAST_NAME}', $this->contact->last_name, $text);
        $text = str_replace('{FULL_NAME}', $this->contact->full_name, $text);
        $text = str_replace('{EMAIL}', $this->contact->email, $text);
        $text = str_replace('{UUID}', $this->contact->uuid, $text);
        return $text;
    }
}
