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
        $this->content = $emailContent;
        $this->loadContent();
    }

}
