<?php

use Azzarip\Teavel\Automations\SequenceAutomation;
use Azzarip\Teavel\Models\Contact;

it('tags contacts', function () {
    $contact = Contact::factory()->create();
    $sequence = new class($contact) extends SequenceAutomation
    {
        public function test()
        {
            $this->tag('tag_test');
        }
    };

    $sequence->test();
    expect($contact->tags()->count())->toBe(1);
    expect($contact->tags()->first()->name)->toBe('tag_test');
});

it('detags contacts', function () {
    $contact = Contact::factory()->create();
    $contact->tag('tag_test');
    $contact->tag('tag_test_2');

    $sequence = new class($contact) extends SequenceAutomation
    {
        public function test()
        {
            $this->detag('tag_test');
        }
    };
    $sequence->test();

    expect($contact->tags()->count())->toBe(1);
    expect($contact->tags()->first()->name)->toBe('tag_test_2');
});
