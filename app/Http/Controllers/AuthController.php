<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->all();
        
        Auth::attempt($credentials);
    
        $user = Auth::user();
    
        if (!Auth::check()) {
            return response()->json([
                'message' => 'Invalid Credentials.'
            ], 401);
        }

        return $user;
    }
}
