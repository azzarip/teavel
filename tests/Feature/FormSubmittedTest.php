<?php

use Azzarip\Teavel\Models\Form;
use Azzarip\Teavel\Models\Contact;
use Illuminate\Support\Facades\Event;
use Azzarip\Teavel\Events\FormSubmitted;
use Azzarip\Teavel\Listeners\FormGoalAchieved;
beforeEach(function() {
    Event::fake();
});

test('contacts can complete a form', function () {
    $contact = Contact::factory()->create();
    $form = Form::name('test');

    $contact->completeForm('test');

    expect($contact->forms()->where('form_id', $form->id)->exists())->toBeTrue();
});

test('forms saves utms from session', function () {
    $contact = Contact::factory()->create();
    $form = Form::name('test');

    session(['utm.source' => '::source::']);
    session(['utm.click_id' => '::click_id::']);
    session(['utm.medium' => '::medium::']);
    session(['utm.campaign' => '::campaign::']);
    session(['utm.term' => '::term::']);
    session(['utm.content' => '::content::']);

    $contact->completeForm($form);
    $compiled_form = $contact->forms()->first()->pivot;

    expect($compiled_form->utm_source)->toBe('::source::');
    expect($compiled_form->utm_medium)->toBe('::medium::');
    expect($compiled_form->utm_campaign)->toBe('::campaign::');
    expect($compiled_form->utm_term)->toBe('::term::');
    expect($compiled_form->utm_content)->toBe('::content::');
    expect($compiled_form->utm_click_id)->toBe('::click_id::');
});

it('dispatches FormSubmittedEvent', function () {
    $contact = Contact::factory()->create();
    $form = Form::name('test');

    $contact->completeForm($form);

    Event::assertDispatched(FormSubmitted::class);
});

test('FormGoalAchieve is listening for FormSubmittedEvent', function () {
    Event::assertListening(
        FormSubmitted::class,
        FormGoalAchieved::class
    );
});
