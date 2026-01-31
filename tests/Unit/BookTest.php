<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Book;

class BookTest extends TestCase
{
    /**
     * Test book model.
     */
    public function test_book_has_attributes(): void
    {
        $book = new Book([
            'book_name' => 'Test Book',
            'author_id' => 1,
        ]);

        $this->assertEquals('Test Book', $book->book_name);
        $this->assertEquals(1, $book->author_id);
    }
}