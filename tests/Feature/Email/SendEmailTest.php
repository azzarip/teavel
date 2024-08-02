<?php

use Azzarip\Teavel\Mail\TeavelMail;
use Azzarip\Teavel\Models\Contact;
use Azzarip\Teavel\Models\ContactEmail;
use Azzarip\Teavel\Models\Email;
use Azzarip\Teavel\Models\EmailFile;
use Illuminate\Support\Facades\Mail;

beforeEach(function () {
    Mail::fake();
    $this->contact = Contact::factory()->create([
        'marketing_at' => now(),
    ]);
    EmailFile::create(['file' => 'test']);
});

it('creates a contact_email entry', function () {

    $this->contact->sendEmail('test');

    $email = Email::first();
    expect($email->contacts()->first()->id)->toBe($this->contact->id);
    $this->assertDatabaseHas('contact_email', [
        'contact_id' => $this->contact->id,
        'email_id' => $email->id,
    ]);
});

it('renews the email if it exists ', function () {

    $email = Email::name('test');

    ContactEmail::create([
        'contact_id' => $this->contact->id,
        'email_id' => $email->id,
        'sent_at' => now()->subDay(),
        'clicked_at' => now()->subHour(),
    ]);

    $this->contact->sendEmail('test');

    expect($email->contacts()->first()->clicked_at)->toBe(null);
});

it('sends an email to contact', function () {
    $email = Email::name('test');

    $this->contact->sendEmail('test');
    Mail::assertSent(function (TeavelMail $mail) {
        return $mail->hasTo($this->contact->email);
    });
});

it('does not send if marketing_at is empty', function () {
    $this->contact->disableMarketing();

    $this->contact->sendEmail('test');

    expect(ContactEmail::count())->toBe(0);
    Mail::assertNotSent(TeavelMail::class);
});
