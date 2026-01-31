<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Author;

class AuthorTest extends TestCase
{
    /**
     * Test author model.
     */
    public function test_author_has_attributes(): void
    {
        $author = new Author([
            'author_name' => 'Test Author',
            'genre' => 'Test bio',
        ]);

        $this->assertEquals('Test Author', $author->author_name);
        $this->assertEquals('Test bio', $author->genre);
    }
}