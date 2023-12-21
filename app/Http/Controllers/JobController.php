<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Support\Facades\Log;
use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\HttpClient\HttpClient;
use Illuminate\Http\Request;
use Exception;

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

    public function show($id)
    {
        $job = Job::find($id);

        if (!$job) {
            return response()->json(['error' => 'Job not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json(['job' => $job]);
    }

    public function destroy($id)
    {
        // Delete a job by ID
    }
}

