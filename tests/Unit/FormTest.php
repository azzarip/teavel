<?php

use Azzarip\Teavel\Models\Contact;
use Azzarip\Teavel\Models\Form;

it('returns form by name', function () {
    $form1 = Form::create(['name' => 'test']);
    $form2 = Form::name('test');

    expect($form1->id)->toBe($form2->id);
});

it('creates a new form if does not exist', function () {
    Form::name('test');

    expect(Form::count())->toBe(1);
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
