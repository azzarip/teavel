<?php

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
