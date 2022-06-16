<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteUserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_delete_user()
    {
        User::factory()
            ->count(20)
            ->create();

        $response = $this->delete(route('users.destroy', ['userId' => 1]));

        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);
    }
}
