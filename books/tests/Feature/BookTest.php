<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test book creation.
     */
    public function test_book_creation(): void
    {
        $response = $this->post('/api/books', [
            'title' => 'New Book',
            'author_id' => 1,
        ]);

        $response->assertStatus(201);
    }
}