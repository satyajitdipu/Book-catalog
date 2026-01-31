<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Book;
use App\Models\Wishlist;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WishlistTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_add_to_wishlist()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();

        $this->actingAs($user, 'sanctum');

        $response = $this->postJson('/api/wishlists', ['book_id' => $book->book_id]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('wishlists', [
            'user_id' => $user->id,
            'book_id' => $book->book_id
        ]);
    }

    public function test_user_can_view_wishlist()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();
        Wishlist::create(['user_id' => $user->id, 'book_id' => $book->book_id]);

        $this->actingAs($user, 'sanctum');

        $response = $this->getJson('/api/wishlists');

        $response->assertStatus(200);
        $response->assertJsonCount(1);
    }

    public function test_user_can_remove_from_wishlist()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();
        $wishlist = Wishlist::create(['user_id' => $user->id, 'book_id' => $book->book_id]);

        $this->actingAs($user, 'sanctum');

        $response = $this->deleteJson('/api/wishlists/' . $wishlist->id);

        $response->assertStatus(200);

        $this->assertDatabaseMissing('wishlists', [
            'id' => $wishlist->id
        ]);
    }
}