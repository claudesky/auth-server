<?php

namespace Tests;

use App\Models\AuthorizationSource;

trait CreatesAuthorizationSource
{
    private function createAuthorizationSource(?string $name = 'google'): AuthorizationSource
    {
        return AuthorizationSource::create([
            'name' => $name,
            'client_id' => '123abc',
            'client_secret' => '456def',
        ]);
    }
}
