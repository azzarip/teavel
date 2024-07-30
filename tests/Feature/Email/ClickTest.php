<?php

use function Pest\Laravel\get;
use Azzarip\Teavel\Models\Email;
use Azzarip\Teavel\Models\Contact;
use Azzarip\Teavel\Models\ContactEmail;

beforeAll(function() {
    $path = __DIR__ . '/../../../vendor/orchestra/testbench-core/laravel/content/emails';
    if (!file_exists($path)) {
        mkdir($path , 0755, true);
        copy(__DIR__ . '/../../Mocks/Email.md', $path . '/test.md');
    }
});

beforeEach(function() {
    $this->contact = Contact::factory()->create(['marketing_at' => now()]);
    $this->email = Email::name('test');
    ContactEmail::create([
        'contact_id' => $this->contact->id,
        'email_id' => $this->email->id,
        'sent_at' => now()->subDay(),
    ]);
});


it('redirects', function () {
    get("/emails/{$this->email->uuid}/clrd/0/{$this->contact->uuid}")->assertRedirect('https://example.com/');
});

it('returns 404 if wrong email', function () {
    get("/emails/WRONG/clrd/0/{$this->contact->uuid}")->assertNotFound();
});

it('returns 404 if wrong number', function () {
    get("/emails/{$this->email->uuid}/clrd/3/{$this->contact->uuid}")->assertNotFound();
});

it('signes the email as clicked', function () {
    get("/emails/{$this->email->uuid}/clrd/0/{$this->contact->uuid}");
expect(ContactEmail::first()->clicked_at)->not->toBeNull();
});
