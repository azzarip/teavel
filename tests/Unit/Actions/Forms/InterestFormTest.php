<?php

use Azzarip\Teavel\Models\Contact;
use Illuminate\Support\Facades\Event;
use Azzarip\Teavel\Actions\Forms\InterestForm;
use Azzarip\Teavel\Actions\Forms\OfferInterest;

beforeEach(function () {
    Event::fake();
});

test('if not auth return false', function () {
    expect(InterestForm::achieve('test', 'test'))->toBeNull();
});

test('auth contacts can complete a form and save cache', function () {
    $contact = Contact::factory()->create();
    $this->actingAs($contact);

    InterestForm::achieve('test', 'test');   

    expect($contact->forms()->exists())->toBeTrue();
    expect(cache()->has('form.test.1'));
});

