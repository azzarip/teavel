<?php

namespace Azzarip\Teavel\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TeavelMail extends Mailable

{
    use Queueable;
    use SerializesModels;

    public function __construct(protected EmailContent $emailContent)
    {
        $this->html = $emailContent->render();
 
        $this->subject = $emailContent->subject;

        $this->setAddress($emailContent->contact->email, $emailContent->contact->full_name);
    }

}
