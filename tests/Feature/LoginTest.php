<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    private function performValidLogin(User $user)
    {
        return $this->json(
            'POST',
            '/login',
            [
                'email' => $user->email,
                'password' => 'password'
            ]
        );
    }

    private function performInvalidLogin(User $user)
    {
        return $this->json(
            'POST',
            '/login',
            [
                'email' => $user->email,
                'password' => 'wrongpassword'
            ]
        );
    }

    public function testValidLoginSuceeds()
    {
        $user = User::factory()->create();

        $response = $this->performValidLogin($user);

        $response->assertStatus(200);

        $response->assertJsonFragment(
            $user->toArray()
        );

        $this->assertAuthenticatedAs($user);
    }

    public function testInvalidLoginFails()
    {
        $user = User::factory()->create();

        $response = $this->performInvalidLogin($user);

        $response->assertStatus(401);

        $response->assertJson([
            'message' => 'Invalid Credentials.'
        ]);

        $this->assertGuest();
    }

    public function testValidLoginSetsCookie()
    {
        $user = User::factory()->create();

        $response = $this->performValidLogin($user);

        $response->assertCookie(config('session.cookie'));
    }

    public function testInvalidLoginDoesNotSetCookie()
    {
        $user = User::factory()
            ->create();

        $response = $this->performInvalidLogin($user);

        $response->assertCookieMissing(config('session.cookie'));
    }
}
