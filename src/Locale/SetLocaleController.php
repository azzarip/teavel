<?php 

namespace Azzarip\Teavel\Locale;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Routing\Controller;

class SetLocaleController extends Controller
{
    public function __invoke(Request $request, string $locale)
    {
        $supported = config('teavel.supported_locales', []);

        if (!in_array($locale, $supported)) {
            abort(400, "Unsupported locale: {$locale}");
        }
        
        SetCookie::locale($locale);
        
        return redirect()->back();
    }
}
