<?php

use Azzarip\Teavel\Models\Form;
use Azzarip\Teavel\Models\Contact;

test('something', function () {
    $contact = Contact::factory()->create();
    $this->artisan('make:teavel-form form');
    $form = Form::name('form');


});
