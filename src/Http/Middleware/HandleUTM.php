<?php

namespace Azzarip\Teavel\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Azzarip\Teavel\Actions\StoreUTM;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class HandleUTM
{
    public function handle(Request $request, Closure $next): Response
    {        
        $data = [];

        if ($request->has('utm_source')) {
            $data = [
                'source' => $request->get('utm_source'),
                'medium' => $request->get('utm_medium'),
                'campaign' => $request->get('utm_campaign'),
                'content' => $request->get('utm_content'),
                'term' => $request->get('utm_term'),
                'click_id' => null,
            ];

            if($request->has('gclid') && $request->get('utm_source') == 'google') {
               $data['click_id'] = $request->get('gclid');
            }

        } elseif ($request->has('gclid')) {
            $data = [
                'source' => 'google',
                'medium' => 'cpc',
                'click_id' => $request->get('gclid'),
            ];      
        } elseif($request->has('utt')) {
            Session::store('utm', $request->get('utt'));
        }

        StoreUTM::store($data);

        return $next($request);
    }
}
