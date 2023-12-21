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
        try {
            $browser = new HttpBrowser(HttpClient::create());
            $scrapedData = [];

            foreach ($this->scrapingJob->urls as $url) {
                $crawler = $browser->request('GET', $url);
                foreach ($this->scrapingJob->selectors as $selector) {
                    $scrapedData[$url][$selector] = $crawler->filter($selector)->each(function ($node) {
                        return $node->text();
                    });
                }
            }

            $this->scrapingJob->scraped_data = $scrapedData;
            $this->scrapingJob->status = 'completed';
            $this->scrapingJob->save();

        } catch (Exception $e) {
            Log::error('Scraping error: ' . $e->getMessage());

            $this->scrapingJob->status = 'failed';
            $this->scrapingJob->save();
        }
    }
}


