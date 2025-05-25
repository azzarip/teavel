        Route::get('/up', fn () => response()->json(
            status: 200,
        ));

        <?php

namespace Azzarip\Teavel\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UpController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return response()->json(
                status: 200,
            );
    }

}
