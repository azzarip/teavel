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

    public string $unsubscribeLink;

    public array $ctas;
    public array $texts;
    public string $url;

    public string $emailUuid;
    /**
     * Create a new message instance.
     */
    public function __construct(public Contact $contact, Email $email)
    {
        $this->emailUuid = $email->uuid;

        $content = $email->getContent();
        $this->subject = $this->parseText($content->subject);
        $this->unsubscribeLink = $this->getUnsubscribeLink();
        $this->url = $this->getClickUrl();


        $body = $this->prepareBody($content->getBody());
        $this->texts = array_map([$this, 'parseText'], $body['texts']);
        $this->ctas = $body['ctas'];

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


    protected function getUnsubscribeLink()
    {
        return url("/emails/{$this->contact->uuid}/unsubscribe/{$this->emailUuid}");
    }

    protected function getClickUrl()
    {
        return url("/emails/{$this->emailUuid}/clrd/{$this->contact->uuid}/") . '/';
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

    protected function prepareBody($body)
    {
        $texts = $body['texts'];
        $ctas = $body['ctas'];

        $part = 0;
        $counter = 0;

        $redactedTexts = [];
        $redactedCtas = [];
        while ($part < count($texts)) {
            $redactedTexts[] = preg_replace_callback('/\[DUMMY_URL\]/', function($matches) use (&$counter) {
                $replacement = "{$this->url} . {$counter}";
                $counter++;
                return $replacement;
            }, $texts[$part]);

            $redactedCtas[] = [
                'link' => "{$this->url} . {$counter}",
                'text' => $ctas[$part],
            ];
            $counter++;
        }


        return [
            'texts' => $redactedTexts,
            'ctas' => $redactedCtas,
        ];
    }
}
