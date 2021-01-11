<?php

namespace Tests\Feature;

use App\Models\AuthenticationRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\CreatesAuthorizationSource;
use Tests\TestCase;

class AuthorizationSourcesTest extends TestCase
{
    use RefreshDatabase, CreatesAuthorizationSource;

    private $base_url = '/authorization_sources';

    public function testIndexAuthorizationSourcesWorks()
    {
        $model_1 = $this->createAuthorizationSource('google');
        $model_2 = $this->createAuthorizationSource('facebook');

        $models = collect([$model_1, $model_2]);

        $url = $this->base_url;

        $response = $this->get($url);

        $response->assertSuccessful();
        $response->assertJson($models->toArray());
    }

    public function testCreateAuthorizationSourceWorks()
    {
        $url = $this->base_url;

        $payload = [
            'name' => 'google',
            'client_id' => '123abc',
            'client_secret' => '456def',
            'config' => ['hello' => 'world'],
        ];

        $response = $this->json(
            'POST',
            $url,
            $payload
        );

        $response->assertSuccessful();
        $response->assertJson($payload);
    }

    public function testCreateAuthorizationSourceCachesConfig()
    {
        $url = $this->base_url;

        $payload = [
            'name' => 'google',
            'client_id' => '123abc',
            'client_secret' => '456def',
            'config' => ['hello' => 'world'],
        ];

        $expected_cache = [
            'google' => array_merge(
                [
                    'id' => 1,
                    'redirect' => secure_url('/callback'),
                ],
                $payload
            )
        ];

        Cache::shouldReceive('put')
            ->once()
            ->with(
                'authorization_sources',
                $expected_cache
            );

        $response = $this->json(
            'POST',
            $url,
            $payload
        );

        $response->assertSuccessful();
        $response->assertJson($payload);
    }

    public function testNewAuthorizationSourceReturnsRedirectUrl()
    {
        $this->createAuthorizationSource('google');

        $url = '/auth/google';

        $response = $this->get($url);

        $response->assertSuccessful();
        $response->assertJsonStructure(['redirect']);

        $authentication_request = AuthenticationRequest::first();

        $redirect_url = $response->json('redirect');
        $this->assertStringContainsString($authentication_request->nonce, $redirect_url);
        $this->assertStringContainsString('google', $redirect_url);
    }

    public function testNoAuthorizationSourceFails()
    {
        $url = '/auth/google';

        $response = $this->get($url);

        $response->assertStatus(404);
    }

    public function testShowAuthorizationSourceWorks()
    {
        $model = $this->createAuthorizationSource();

        $url = $this->base_url . "/$model->id";

        $response = $this->get($url);

        $response->assertSuccessful();
        $response->assertJson($model->toArray());
    }

    public function testUpdateAuthorizationSourceWorks()
    {
        $model = $this->createAuthorizationSource();

        $url = $this->base_url . "/$model->id";

        $payload = [
            'name' => 'twitter',
        ];

        $response = $this->json(
            'PUT',
            $url,
            $payload
        );

        $response->assertSuccessful();
        $response->assertJsonFragment($payload);
    }

    public function testDeleteAuthorizationSourceWorks()
    {
        $model = $this->createAuthorizationSource();

        $url = $this->base_url . "/$model->id";

        $response = $this->delete($url);

        $response->assertSuccessful();
        $response->assertNoContent();
    }
}
