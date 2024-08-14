<?php

use Azzarip\Teavel\Automations\SequenceAutomation;
use Azzarip\Teavel\Models\Contact;
use Azzarip\Teavel\Models\ContactEmail;
use Azzarip\Teavel\Models\Email;

use function Pest\Laravel\get;

beforeAll(function () {
    $path = __DIR__ . '/../../../vendor/orchestra/testbench-core/laravel/content/emails';
    if (! file_exists($path)) {
        mkdir($path, 0755, true);
        copy(__DIR__ . '/../../Mocks/Email.md', $path . '/test.md');
    }
});

beforeEach(function () {
    $this->contact = Contact::factory()->create();

    $this->email = Email::name(Azzarip\Teavel\Tests\Mocks\EmailMock::class);

    ContactEmail::create([
        'contact_id' => $this->contact->id,
        'email_id' => $this->email->id,
        'sent_at' => now()->subDay(),
    ]);
});



it('returns 404 if wrong action', function () {
    get("/tvl/{$this->contact->uuid}/email/{$this->email->uuid}/WRONG")->assertNotFound();
});

it('redirects', function () {
    get("/tvl/{$this->contact->uuid}/email/{$this->email->uuid}/click")->assertRedirect();
});

it('signes the email as clicked', function () {
    get("/tvl/{$this->contact->uuid}/email/{$this->email->uuid}/click");
    expect(ContactEmail::first()->clicked_at)->not->toBeNull();
});

it('returns 404 if wrong contact', function () {
    get("/tvl/WRONG/email/{$this->email->uuid}/click")->assertNotFound();
});

it('returns 404 if wrong email', function () {
    get("/tvl/{$this->contact->uuid}/email/WRONG_EMAIL/click")->assertNotFound();
});
