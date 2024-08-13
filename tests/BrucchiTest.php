<?php

use Azzarip\Teavel\Models\Email;
use Azzarip\Teavel\Models\Contact;
use Azzarip\Teavel\Mail\TeavelMail;
use Azzarip\Teavel\Models\EmailFile;

test('email', function () {
    $contact = Contact::factory()->create([
        'marketing_at' => now()
    ]);
    $email = Email::create([
        'file_id' => 1
    ]);

    $emailFile = EmailFile::create([
        'file' => 'test'
    ]);
    dd($email->getContent()->html);


});
