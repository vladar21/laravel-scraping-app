<?php

namespace Tests\Feature;

use App\Jobs\ScrapeWebsiteJob;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Job as Job;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Queue;

class JobControllerTest extends TestCase
{
    use RefreshDatabase;


    public function testStoreMethod()
    {
        Queue::fake();

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

        // Check that the job has been added to the queue
        Queue::assertPushed(ScrapeWebsiteJob::class);
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
                'job_id' => $job->id,
                'urls' => ['http://example.com'],
                'selectors' => ['h1', 'p'],
            ]);
    }

    public function testDestroyMethod()
    {
        // Create a job instance for testing
        $job = Job::create([
            'urls' => ['http://example.com'],
            'selectors' => ['h1', 'p']
        ]);

        $response = $this->json('DELETE', "/api/jobs/{$job->id}");

        $response->assertStatus(Response::HTTP_OK);

        $this->assertDatabaseMissing('jobs', ['id' => $job->id]);
    }

    public function testJobProcessing()
    {
        $this->withoutExceptionHandling();

        // Create a job instance
        $job = Job::create([
            'urls' => ['http://example.com'],
            'selectors' => ['h1', 'p'],
            'status' => 'queued'
        ]);

        // Create and process the job
        $scrapeJob = new ScrapeWebsiteJob($job);
        $scrapeJob->handle();

        // Check job status after execution
        $job = $job->fresh(); // Receive an updated record
        $this->assertEquals('completed', $job->status);
    }
}
