<?php

namespace Azzarip\Teavel\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Azzarip\Teavel\Models\Contact;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;

class TeavelMail extends TeavelMailable

{
    use Queueable;
    use SerializesModels;

    public function __construct(string $filename, protected array $data = [])
    {
    }


    protected function getFilename() {
        return $this->filename;
    }


}
