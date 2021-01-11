<?php

namespace App\Observers;

use Illuminate\Support\Str;
use App\Models\AuthenticationRequest;

class AuthenticationRequestObserver
{
    public function creating(AuthenticationRequest $authenticationRequest)
    {
        $authenticationRequest->nonce = Str::random(63);
    }
}
