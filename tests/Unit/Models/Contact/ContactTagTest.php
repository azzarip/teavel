<?php

use Azzarip\Teavel\Models\Contact;

it('can be tagged/detagged', function () {
    $contact = Contact::factory()->create();

    $contact->tag('test');
    expect($contact->tags()->count())->toBe(1);

    $contact->detag('test');
    expect($contact->tags()->count())->toBe(0);
});


it('hasTag', function () {
    $contact = Contact::factory()->create();

    $contact->tag('test');
    expect($contact->hasTag('test'))->toBeTrue();

});

it('hasTags', function () {
    $contact = Contact::factory()->create();

    $contact->tag('tag-true');
    $contact->tag('tag-false');
    $contact->detag('tag-false');

    $result = $contact->hasTags(['tag-true', 'tag-false', 'tag-null']);
    expect($result)->toBeArray();
    expect($result)->toBe([
        'tag-true' => true, 
        'tag-false' => false, 
        'tag-null' => false
    ]);

});