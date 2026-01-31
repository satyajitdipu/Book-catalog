<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test book creation.
     */
    public function test_book_creation(): void
    {
        $response = $this->get('/api/allbook/1');

        $response->assertStatus(200);
    }
}