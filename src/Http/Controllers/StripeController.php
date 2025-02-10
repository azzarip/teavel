<?php

namespace Domains\Api\Http\Controllers;

use Stripe\Webhook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Azzarip\Teavel\Events\StripeWebhookReceived;
use Stripe\Exception\SignatureVerificationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class StripeController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $event = $this->getEvent($request);

        event(new StripeWebhookReceived($event));

        return response('', 200);
    }

    
    protected function getEvent(Request $request) {
        try {
            return Webhook::constructEvent(
                $request->getContent(),
                $request->header('Stripe-Signature'),
                config('services.stripe.signature')
            );
        } catch (SignatureVerificationException $exception) {
            Log::error('Stripe Signing Signature');
            throw new AccessDeniedHttpException($exception->getMessage(), $exception);
        }
    }

}
