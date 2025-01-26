<?php 

namespace Azzarip\Teavel\Actions\Stripe;

use Azzarip\Teavel\Models\Contact;

class CreateStripeContact 
{   
    public static function create(Contact $contact)
    {
        if($contact->stripe_id) return;
        
        $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));
        $response = $stripe->customers->create([
            'name' => $contact->full_name,
            'email' => $contact->email,
            'phone' => $contact->phone,
            'metadata' => [
                'id' => $contact->id,
                'uuid' => $contact->uuid,
            ],
        ]);
        $contact->update(['stripe_id' => $response->id]);

        return true;
    }
}