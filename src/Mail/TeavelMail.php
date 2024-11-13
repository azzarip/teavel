<?php

namespace Azzarip\Teavel\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;

class TeavelMail extends TeavelMailable

{
    use Queueable;
    use SerializesModels;

    public function __construct(protected EmailContent $emailContent)
    {
        $content = $this->getContent();

        $this->subject = $content->subject;

        $this->to($content->getAddress());
    }

    protected function getContent()
    {
        return $this->emailContent;
    }


}
