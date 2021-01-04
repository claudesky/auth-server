<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Login
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $credentials = $request->all();
        
        Auth::attempt($credentials);

        if (!Auth::check()) {
            return response()->json([
                'message' => 'Invalid Credentials.'
            ], 401);
        }

        session('last_active', now());

        return $next($request);
    }
}
