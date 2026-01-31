<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorSearchTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test author search feature.
     */
    public function test_author_search_feature(): void
    {
        $response = $this->get('/api/allauthor');

        $response->assertStatus(200);
    }
}