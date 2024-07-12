<?php

use Azzarip\Teavel\Models\Contact;


it('can be tagged/detagged', function () {
    $contact = Contact::factory()->create();

    $contact->tag('test');
    expect($contact->tags()->count())->toBe(1);

    $contact->detag('test');
    expect($contact->tags()->count())->toBe(0);
});
