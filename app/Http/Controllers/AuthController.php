<?php

namespace App\Http\Controllers;

use App\Models\AuthorizationSource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware(['session'], [
            'only' => ['login']
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->all();
        
        Auth::attempt($credentials);

        if (!Auth::check()) {

            return response()->json([
                'message' => 'Invalid Credentials.'
            ], 401);

        }

        session(['last_login' => now()->timestamp]);

        return auth()->user();
    }

    public function logout(Request $request)
    {

    }

    public function authRequest(AuthorizationSource $authorization_source)
    {
        /** @var AbstractProvider */
        $driver = Socialite::driver($authorization_source->name);
    
        $location = $driver
            ->stateless()
            ->redirect()
            ->headers
            ->get('Location');
    
        $authentication_request = $authorization_source
            ->authentication_requests()
            ->create();
        
        $location .= "&state=$authentication_request->nonce";
    
        return [
            'redirect' => $location
        ];
    }
}
