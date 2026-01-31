<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test author creation.
     */
    public function test_author_creation(): void
    {
        $response = $this->get('/api/allauthor');

        $response->assertStatus(200);
    }
}