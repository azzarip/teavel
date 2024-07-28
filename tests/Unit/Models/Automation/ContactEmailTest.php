<?php

use Azzarip\Teavel\Models\Email;
use Azzarip\Teavel\Models\Contact;
use Azzarip\Teavel\Models\EmailFile;
use Azzarip\Teavel\Models\ContactEmail;


it('creates a contact_email entry', function () {
    $contact = Contact::factory()->create();

    EmailFile::create(['file'=>'test']);

    $contact->sendEmail('test');

    $email= Email::first();
    expect(Email::count())->toBe(1);
    expect($email->contacts()->first()->id)->toBe($contact->id);
    $this->assertDatabaseHas('contact_email', [
        'contact_id' => $contact->id,
        'email_id' => $email->id,
    ]);
});

it('renews the email if it exists ', function () {
    $contact = Contact::factory()->create();

    EmailFile::create(['file'=>'test']);
    $email= Email::name('test');

    ContactEmail::create([
        'contact_id' => $contact->id,
        'email_id' => $email->id,
        'sent_at' => now()->subDay(),
        'clicked_at' => now()->subHour(),
    ]);

    $contact->sendEmail('test');

    expect($email->contacts()->first()->clicked_at)->toBe(null);
});
