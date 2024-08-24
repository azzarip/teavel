<?php

namespace Azzarip\Teavel\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;

class TeavelMail extends TeavelMailable

{
    use Queueable;
    use SerializesModels;

    public function __construct(protected EmailContent $emailContent, protected array $data = [])
    {
    }

    protected function getContent()
    {
        return $this->emailContent;
    }


}
