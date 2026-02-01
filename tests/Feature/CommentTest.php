<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_comment()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();

        $this->actingAs($user);

        $response = $this->postJson('/api/comments', [
            'book_id' => $book->book_id,
            'content' => 'This is a great book!',
        ]);

        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'id',
                     'book_id',
                     'user_id',
                     'content',
                     'created_at',
                     'updated_at',
                     'user' => [
                         'id',
                         'name',
                         'email',
                     ],
                 ]);

        $this->assertDatabaseHas('comments', [
            'book_id' => $book->book_id,
            'user_id' => $user->id,
            'content' => 'This is a great book!',
        ]);
    }

    public function test_user_can_update_own_comment()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();
        $comment = Comment::factory()->create([
            'book_id' => $book->book_id,
            'user_id' => $user->id,
            'content' => 'Old comment',
        ]);

        $this->actingAs($user);

        $response = $this->putJson("/api/comments/{$comment->id}", [
            'content' => 'Updated comment',
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'content' => 'Updated comment',
                 ]);

        $this->assertDatabaseHas('comments', [
            'id' => $comment->id,
            'content' => 'Updated comment',
        ]);
    }

    public function test_user_cannot_update_others_comment()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $book = Book::factory()->create();
        $comment = Comment::factory()->create([
            'book_id' => $book->book_id,
            'user_id' => $otherUser->id,
            'content' => 'Other user comment',
        ]);

        $this->actingAs($user);

        $response = $this->putJson("/api/comments/{$comment->id}", [
            'content' => 'Trying to update',
        ]);

        $response->assertStatus(403);
    }

    public function test_user_can_delete_own_comment()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();
        $comment = Comment::factory()->create([
            'book_id' => $book->book_id,
            'user_id' => $user->id,
        ]);

        $this->actingAs($user);

        $response = $this->deleteJson("/api/comments/{$comment->id}");

        $response->assertStatus(200);

        $this->assertDatabaseMissing('comments', [
            'id' => $comment->id,
        ]);
    }

    public function test_can_get_comments_for_book()
    {
        $book = Book::factory()->create();
        $user = User::factory()->create();
        Comment::factory()->count(3)->create([
            'book_id' => $book->book_id,
            'user_id' => $user->id,
        ]);

        $response = $this->getJson("/api/books/{$book->book_id}/comments");

        $response->assertStatus(200)
                 ->assertJsonCount(3, 'data');
    }
}