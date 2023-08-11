<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ValidateCrsf
{
    public function handle(Request $request, Closure $next)
    {
        // $csrfToken = $request->header('X-CSRF-TOKEN');
        // $hash = hash_hmac('sha256', env('APP_CSRF_SALT'), env('APP_CSRF_KEY'));

        // if (!Hash::check($hash, $csrfToken)) {
        //     return response()->json(['message' => 'Invalid CSRF token or signature'], 400);
        // }

        return $next($request);
    }
}
