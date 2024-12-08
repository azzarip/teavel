<?php

use Azzarip\Teavel\Models\Contact;
use Illuminate\Support\Facades\Event;
use Azzarip\Teavel\Actions\Forms\SafeFormComplete;

beforeEach(function () {
    Event::fake();
});

test('auth contacts can complete a form and save session', function () {
    $contact = Contact::factory()->create();
    $this->actingAs($contact);

    SafeFormComplete::complete('testClass', 'test');   

    expect($contact->forms()->exists())->toBeTrue();
    expect(session()->has('test.form'));
});



test('session contacts can complete a form and save session', function () {
    $contact = Contact::factory()->create();
    
    session()->put('contact', $contact->id);

    SafeFormComplete::complete('testClass', 'test');   

    expect($contact->forms()->exists())->toBeTrue();
    expect(session()->has('test.form'));
});

test('if empty contact does nothing', function () {
    $contact = Contact::factory()->create();
    

    SafeFormComplete::complete('testClass', 'test');   
    
    expect($contact->forms()->exists())->toBeFalse();
    expect(session()->has('test.form'))->toBeFalse();
});