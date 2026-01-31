<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_profile()
    {
        // Test implementation
        $response = $this->get('/api/user/profile');

        $response->assertStatus(200);
    }

    public function test_user_can_update_profile()
    {
        // Test implementation
        $data = ['name' => 'Updated Name'];
        $response = $this->put('/api/user/profile', $data);

        $response->assertStatus(200);
    }
}