<?php

use Azzarip\Teavel\Models\Contact;
use Azzarip\Teavel\Models\Email;

use function Pest\Laravel\get;
use function Pest\Laravel\post;

beforeEach(function () {
    $this->contact = Contact::factory()->create(['marketing_at' => now()]);
    $this->email = Email::create(['file_id' => 1]);
});
it('has unsubscribe page', function () {
    get("/emails/{$this->contact->uuid}/unsubscribe/{$this->email->uuid}")
        ->assertOk()
        ->assertSee($this->contact->uuid)
        ->assertSee($this->email->uuid);
});

it('has success page', function () {
    get('/emails/unsubscribe/success')->assertOk();
});

it('sets marketing_at to null', function () {
    post("/emails/{$this->contact->uuid}/unsubscribe/{$this->email->uuid}", []);

    $this->contact->refresh();
    expect($this->contact->can_market)->toBeFalse();
});

it('creates a email_unsubscribe model', function () {
    post("/emails/{$this->contact->uuid}/unsubscribe/{$this->email->uuid}", []);

    $this->assertDatabaseHas('email_unsubscribes', [
        'contact_id' => $this->contact->id,
        'email_id' => $this->email->id,
    ]);
});

it('redirects to emails/success', function () {
    post("/emails/{$this->contact->uuid}/unsubscribe/{$this->email->uuid}")
        ->assertRedirect('emails/unsubscribe/success');
});

it('returns 500 if contact does not exist', function () {
    post("/emails/WRONG/unsubscribe/{$this->email->uuid}")
        ->assertRedirect();

});
