<?php

namespace App\Observers;

use App\Models\AuthorizationSource;
use Illuminate\Support\Facades\Cache;

class AuthorizationSourceObserver
{
    public function refreshConfig()
    {
        $authorization_sources = AuthorizationSource::all()
            ->keyBy('name')
            ->map(function($source) {
                return collect($source)
                    ->except([
                        'updated_at',
                        'created_at',
                    ])
                    ->merge(['redirect' => secure_url('/callback')]);
            })
            ->toArray();

        Cache::put(
            'authorization_sources',
            $authorization_sources
        );

        config([
            'services' => $authorization_sources
        ]);
    }

    public function created()
    {
        $this->refreshConfig();
    }

    public function updated()
    {
        $this->refreshConfig();
    }

    public function deleted()
    {
        $this->refreshConfig();
    }
}
