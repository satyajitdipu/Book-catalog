<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookSearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_book_search_by_title()
    {
        // Test implementation
        $response = $this->get('/api/books?search=Test Book');

        $response->assertStatus(200);
    }

    public function test_book_search_by_author()
    {
        // Test implementation
        $response = $this->get('/api/books?author=Test Author');

        $response->assertStatus(200);
    }
}