<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_profile()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/api/user/profile');

        $response->assertStatus(200);
    }

    public function test_user_can_update_profile()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $data = ['name' => 'Updated Name'];
        $response = $this->put('/api/user/profile', $data);

        $response->assertStatus(200);
    }
}