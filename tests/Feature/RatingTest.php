<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RatingTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_rating()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();

        $this->actingAs($user);

        $response = $this->postJson('/api/ratings', [
            'book_id' => $book->book_id,
            'rating' => 5,
            'comment' => 'Great book!',
        ]);

        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'id',
                     'user_id',
                     'book_id',
                     'rating',
                     'comment',
                     'user' => ['id', 'name'],
                     'book' => ['book_id', 'book_name'],
                 ]);

        $this->assertDatabaseHas('ratings', [
            'user_id' => $user->id,
            'book_id' => $book->book_id,
            'rating' => 5,
            'comment' => 'Great book!',
        ]);
    }

    public function test_get_ratings_for_book()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();
        Rating::factory()->create(['user_id' => $user->id, 'book_id' => $book->book_id]);

        $response = $this->getJson("/api/books/{$book->book_id}/ratings");

        $response->assertStatus(200)
                 ->assertJsonCount(1);
    }
}