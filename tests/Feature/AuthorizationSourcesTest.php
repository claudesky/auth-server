<?php

namespace Tests\Feature;

use App\Models\AuthorizationSource;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorizationSourcesTest extends TestCase
{
    use RefreshDatabase;

    private $base_url = '/authorization_sources';

    private function createAuthorizationSource(?string $name = 'google'): AuthorizationSource
    {
        return AuthorizationSource::create([
            'name' => $name,
            'client_id' => '123abc',
            'client_secret' => '456def',
        ]);
    }

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
