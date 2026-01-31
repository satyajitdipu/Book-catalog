<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test author creation.
     */
    public function test_author_creation(): void
    {
        $response = $this->post('/api/authors', [
            'name' => 'New Author',
            'bio' => 'Bio',
        ]);

        $response->assertStatus(201);
    }
}