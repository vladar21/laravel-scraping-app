<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Job;
use Illuminate\Http\Response;

class JobControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testStoreMethod()
    {
        $payload = [
            'urls' => ['http://example.com'],
            'selectors' => ['h1', 'p']
        ];

        // Assertions for the response
        $response = $this->json('POST', '/api/jobs', $payload);

        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);

        // Assert that the job with given URLs and selectors is stored

        // Fetch the latest job entry
        $job = Job::latest()->first();

        $this->assertNotNull($job, 'No job record found in database');

        // Compare directly if 'urls' and 'selectors' are cast to arrays in the Job model
        $this->assertEquals($payload['urls'], $job->urls);
        $this->assertEquals($payload['selectors'], $job->selectors);

    }

    public function testShowMethod()
    {
        // Create a job instance for testing
        $job = Job::create([
            'urls' => ['http://example.com'],
            'selectors' => ['h1', 'p']
        ]);

        $response = $this->json('GET', "/api/jobs/{$job->id}");

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'job' => [
                    'urls' => ['http://example.com'],
                    'selectors' => ['h1', 'p']
                ]
            ]);
    }
}
