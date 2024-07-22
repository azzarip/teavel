<?php

use Azzarip\Teavel\Models\Contact;
use Azzarip\Teavel\Models\Form;

test('something', function () {
    $contact = Contact::factory()->create();
    $this->artisan('make:teavel-form form');
    $form = Form::name('form');

});
