<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
}
