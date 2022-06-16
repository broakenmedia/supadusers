<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateUserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_update_user()
    {
        User::factory()
            ->count(20)
            ->create();

        $response = $this->post(route('users.update', ['userId' => 1]), ['firstName' => 'Test first name']);

        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);

        $this->assertTrue($response['data']['firstName'] === 'Test first name');
    }
}
