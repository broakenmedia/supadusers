<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetUserTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_be_retrieved()
    {
        User::factory()
            ->count(20)
            ->create();

        $response = $this->get(route('users.show', ['userId' => 1]));

        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);
    }
}
