<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware(['login', 'session'], [
            'only' => ['login']
        ]);
    }

    public function login(Request $request)
    {
        $request->session()->regenerate();

        session(['last_login' => now()->timestamp]);

        return auth()->user();
    }
}
