<?php

use Azzarip\Teavel\Models\Offer;
use Azzarip\Teavel\Models\Contact;
use Illuminate\Support\Facades\Event;
use Azzarip\Teavel\Events\OfferPurchased;
use Azzarip\Teavel\Listeners\OfferGoalAchieved;

beforeEach(function () {
    Event::fake();
});

it('dispatches OfferPurchasedEvent', function () {
    $contact = Contact::factory()->create();
    $offer = Offer::factory()->create();

    OfferPurchased::dispatch($offer, $contact);

    Event::assertDispatched(OfferPurchased::class);
});

test('OfferGoalAchieved is listening for OfferPurchased', function () {
    Event::assertListening(
        OfferPurchased::class,
        OfferGoalAchieved::class
    );
});