<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the allbook API endpoint.
     */
    public function test_allbook_endpoint_returns_successful_response(): void
    {
        $response = $this->get('/api/allbook/1');

        $response->assertStatus(200);
    }

    /**
     * Test the allauthor API endpoint.
     */
    public function test_allauthor_endpoint_returns_successful_response(): void
    {
        $response = $this->get('/api/allauthor');

        $response->assertStatus(200);
    }
}