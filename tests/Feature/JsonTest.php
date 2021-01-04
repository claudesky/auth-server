<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JsonTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testJsonWorks()
    {
        $response = $this->get('/test');

        $response->assertStatus(200);
        $response->assertJson([
            'hello' => 'world!'
        ]);
    }
}
