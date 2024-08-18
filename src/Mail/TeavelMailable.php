<?php

namespace Azzarip\Teavel\Mail;

use Azzarip\Teavel\Models\Contact;

class  TeavelMailable
{
    protected $filename;

    protected array $data;


    public function to(Contact $contact) {
        return new TeavelMail($contact, $this->getFilename(), $this->data);
    }

    protected function getFilename() {
        return base_path() . '/' . $this->filename;
    }
}
