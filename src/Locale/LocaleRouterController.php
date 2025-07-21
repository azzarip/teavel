<?php 

namespace Azzarip\Teavel\Locale;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cookie;

class LocaleRouterController extends Controller
{
    public function __invoke(Request $request)
    {
        $supported = config('teavel.supported_locales', []);

        if (empty($supported)) {
            abort(400, "No supported locales set. Check teavel config.");
        }
        
        $locale = $request->cookie('lang');
        if ($locale && ! in_array($locale, $supported)) {
            Cookie::queue(Cookie::forget('lang'));
            $locale = null;
        }

        if(empty($locale)){
           $locale = $this->extractLocaleFromRequest($request, $supported);
           SetCookie::locale($locale);
        }

        $redirect = $this->getNewPath($request, $locale);
        return redirect($redirect);
    }
    protected function getNewPath($request, $locale){
        $originalPath = ltrim($request->path(), '/');

        if (!str_starts_with($originalPath, $locale . '/')) {
            return "/{$locale}/{$originalPath}";
        }
        else {
            return $request->path(); 
        }
    }

    protected function extractLocaleFromRequest($request, $supported) 
    {
        $accept = $request->getLanguages();

        foreach ($accept as $preferred) {
            $lang = strtolower(substr($preferred, 0, 2));
            if (in_array($lang, $supported)) {
                return $lang;
            }
        }

        return app()->getLocale();
    }
}
