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
            'name' => 'Test Author',
            'bio' => 'Test bio',
        ]);

        $this->assertEquals('Test Author', $author->name);
        $this->assertEquals('Test bio', $author->bio);
    }
}