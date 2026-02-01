<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReviewTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_review()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();

        $this->actingAs($user);

        $data = [
            'book_id' => $book->book_id,
            'rating' => 5,
            'comment' => 'Great book!',
        ];

        $response = $this->post('/api/reviews', $data);

        $response->assertStatus(201);
    }

    public function test_get_reviews_for_book()
    {
        $book = Book::factory()->create();

        $response = $this->get("/api/books/{$book->book_id}/reviews");

        $response->assertStatus(200);
    }
}