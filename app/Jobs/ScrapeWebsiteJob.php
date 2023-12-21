<?php

namespace App\Jobs;

use App\Models\Job;
use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\HttpClient\HttpClient;
use Illuminate\Support\Facades\Log;
use Exception;

class ScrapeWebsiteJob extends Job
{
    protected $scrapingJob;

    public function __construct(Job $job)
    {
        $this->scrapingJob = $job;
    }

    public function handle()
    {
        // Continue with scraping...
        try {
            $browser = new HttpBrowser(HttpClient::create());
            $scrapedData = [];

            foreach ($validatedData['urls'] as $url) {
                $crawler = $browser->request('GET', $url);
                foreach ($validatedData['selectors'] as $selector) {
                    $scrapedData[$url][$selector] = $crawler->filter($selector)->each(function ($node) {
                        return $node->text();
                    });
                }
            }

            $job->scraped_data = $scrapedData;
            $job->save();

        }catch(Exception $e){
            // Log the error or handle it as needed
            Log::error('Scraping error: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred during scraping: ' . $e->getMessage()], 500);
        }

        // Return response
        return response()->json([
            'success' => true,
            'data' => $scrapedData,
        ]);
    }
}

