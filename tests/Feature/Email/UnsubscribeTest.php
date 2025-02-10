<?php

use Azzarip\Teavel\Models\Contact;
use Azzarip\Teavel\Models\Email;

use function Pest\Laravel\get;
use function Pest\Laravel\post;

beforeEach(function () {
    $this->contact = Contact::factory()->create([]);
    $this->email = Email::create(['automation' => '::automation::']);
});

it('has unsubscribe page', function () {
    get("/tvl/{$this->contact->uuid}/email/{$this->email->uuid}/unsubscribe")
        ->assertOk()
        ->assertSee($this->contact->uuid)
        ->assertSee($this->email->uuid);
});

it('has success page', function () {
    get('/tvl/unsubscribe/success')->assertOk();
});

it('sets marketing_at to null', function () {
    post("/tvl/{$this->contact->uuid}/email/{$this->email->uuid}/unsubscribe", []);

    $this->contact->refresh();
    expect($this->contact->can_market)->toBeFalse();
    expect($this->contact->opt_in)->toBeFalse();
});

it('creates a email_unsubscribe model', function () {
    post("/tvl/{$this->contact->uuid}/email/{$this->email->uuid}/unsubscribe", []);

    $this->assertDatabaseHas('email_unsubscribes', [
        'contact_id' => $this->contact->id,
        'email_id' => $this->email->id,
    ]);
});

it('redirects to emails/success', function () {
    post("/tvl/{$this->contact->uuid}/email/{$this->email->uuid}/unsubscribe")
        ->assertRedirect('emails/unsubscribe/success');
});

it('redirects on wrong contact', function () {
    post("/tvl/WRONG/email/{$this->email->uuid}/unsubscribe")
        ->assertRedirect();
});
