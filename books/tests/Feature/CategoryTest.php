<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_list_categories()
    {
        // Test implementation
        $response = $this->get('/api/categories');

        $response->assertStatus(200);
    }

    public function test_create_category()
    {
        // Test implementation
        $data = ['name' => 'Fiction'];
        $response = $this->post('/api/categories', $data);

        $response->assertStatus(201);
    }
}