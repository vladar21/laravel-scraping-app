<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\HttpClient\HttpClient;

class JobController extends Controller
{
    public function store(Request $request)
    {
        // Validate and create a job
        $validatedData = $request->validate([
            'urls' => 'required|array',
            'urls.*' => 'required|url',
            'selectors' => 'required|array',
        ]);

        $job = new Job();
        $job->urls = $validatedData['urls'];
        $job->selectors = $validatedData['selectors'];
        $job->save();

        // Continue with scraping...
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

        // Return response or continue...

    }

    public function show($id)
    {
        // Retrieve and return a job by ID
    }

    public function destroy($id)
    {
        // Delete a job by ID
    }
}

