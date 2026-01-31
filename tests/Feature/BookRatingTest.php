<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookRatingTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test book rating feature.
     */
    public function test_book_rating_feature(): void
    {
        $response = $this->get('/api/allbook/1');

        $response->assertStatus(200);
    }
}