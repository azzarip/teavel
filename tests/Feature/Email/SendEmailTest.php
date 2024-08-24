<?php

use Azzarip\Teavel\Mail\TeavelMail;
use Azzarip\Teavel\Models\Contact;
use Azzarip\Teavel\Models\ContactEmail;
use Azzarip\Teavel\Models\Email;
use Azzarip\Teavel\Models\EmailFile;
use Illuminate\Support\Facades\Mail;

beforeEach(function () {
    Mail::fake();
    $this->contact = Contact::factory()->create();
    $this->email = Email::name(Azzarip\Teavel\Tests\Mocks\EmailMock::class);
});

it('creates a contact_email entry', function () {

    $this->contact->sendEmail(Azzarip\Teavel\Tests\Mocks\EmailMock::class);

    expect($this->email->contacts()->first()->id)->toBe($this->contact->id);
    $this->assertDatabaseHas('contact_email', [
        'contact_id' => $this->contact->id,
        'email_id' => $this->email->id,
    ]);
});

it('renews the email if it exists ', function () {

    ContactEmail::create([
        'contact_id' => $this->contact->id,
        'email_id' => $this->email->id,
        'sent_at' => now()->subDay(),
        'clicked_at' => now()->subHour(),
    ]);

    $this->contact->sendEmail(Azzarip\Teavel\Tests\Mocks\EmailMock::class);

    expect($this->email->contacts()->first()->clicked_at)->toBe(null);
});

it('sends an email to contact', function () {
    $this->contact->sendEmail(Azzarip\Teavel\Tests\Mocks\EmailMock::class);

    Mail::assertSent(function (TeavelMail $mail) {
        return $mail->hasTo($this->contact->email);
    });
});

it('does not send if opt_in is false', function () {
    $this->contact->emailOptOut();

    $this->contact->sendEmail(Azzarip\Teavel\Tests\Mocks\EmailMock::class);

    expect(ContactEmail::count())->toBe(0);
    Mail::assertNotSent(TeavelMail::class);
});

it('does not send if marketing_at and email marketing', function () {
    $this->contact->disableMarketing();

    $this->contact->sendEmail(Azzarip\Teavel\Tests\Mocks\EmailMock::class);

    expect(ContactEmail::count())->toBe(0);
    Mail::assertNotSent(TeavelMail::class);
});
