<?php

namespace Azzarip\Teavel\Http\Controllers;

use Stripe\Stripe;
use Stripe\Webhook;
use Illuminate\Http\Request;
use Stripe\WebhookSignature;
use Illuminate\Support\Facades\Log;
use Stripe\Exception\SignatureVerificationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class StripeController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $this->verifyWebhook($request);



        return response('', 200);
    }

    
    protected function verifyWebhook(Request $request)
    {
        try {
            WebhookSignature::verifyHeader(
                $request->getContent(),
                $request->header('Stripe-Signature'),
                config('services.stripe.signature'),
                Webhook::DEFAULT_TOLERANCE
            );
        } catch (SignatureVerificationException $exception) {
            Log::error('Stripe Signing Signature');
            throw new AccessDeniedHttpException($exception->getMessage(), $exception);
        }
    }

    protected function setMaxNetworkRetries($retries = 3)
    {
        Stripe::setMaxNetworkRetries($retries);
    }
}
