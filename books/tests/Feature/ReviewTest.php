<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReviewTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_review()
    {
        $data = [
            'book_id' => 'book1',
            'user_id' => 1,
            'rating' => 5,
            'comment' => 'Great book!',
        ];

        $response = $this->post('/api/reviews', $data);

        $response->assertStatus(201);
    }

    public function test_get_reviews_for_book()
    {
        $response = $this->get('/api/books/book1/reviews');

        $response->assertStatus(200);
    }
}