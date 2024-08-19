<?php

use Azzarip\Teavel\Models\Contact;

it('logs out', function () {
    $contact = Contact::factory()->create();
    $this->actingAs($contact);

    $this->post('/logout')->assertRedirect('/');
    $this->assertGuest();
});
