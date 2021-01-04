<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that a login with valid credentials works as succeeds
     *
     * @return void
     */
    public function testValidLoginSuceeds()
    {
        $user = User::factory()
            ->create();

        $response = $this->json(
            'POST',
            '/login',
            [
                'email' => $user->email,
                'password' => 'password'
            ]
        );

        $response->assertStatus(200);

        $response->assertJsonFragment(
            $user->toArray()
        );

        $this->assertAuthenticatedAs($user);
    }

    /**
     * Test that a login with invalid credentials fails
     *
     * @return void
     */
    public function testInvalidLoginFails()
    {
        $user = User::factory()
            ->create();

        $response = $this->json(
            'POST',
            '/login',
            [
                'email' => $user->email,
                'password' => 'wrongpassword'
            ]
        );

        $response->assertStatus(401);

        $response->assertJson([
            'message' => 'Invalid Credentials.'
        ]);

        $this->assertGuest();
    }
}
