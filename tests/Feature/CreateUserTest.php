<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateUserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_create_user()
    {
        User::factory()
            ->count(20)
            ->create();

        $response = $this->post(route('users.store'), ['firstName' => 'Test first name', 'lastName' => 'Test last name', 'email' => 'testemail@test.com', 'password' => '12345678', 'password_confirm' => '12345678']);

        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);

        $this->assertTrue($response['data']['firstName'] === 'Test first name');
        $this->assertTrue($response['data']['lastName'] === 'Test last name');
        $this->assertTrue($response['data']['email'] === 'testemail@test.com');
    }
}
