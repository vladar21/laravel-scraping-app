<?php

namespace App\Http\Controllers;

use App\Jobs\ScrapeWebsiteJob;
use App\Models\Job;
use Illuminate\Support\Facades\Log;
use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\HttpClient\HttpClient;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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

        ScrapeWebsiteJob::dispatch($job);

        // Возврат ответа о том, что задание добавлено в очередь
        return response()->json([
            'success' => true,
            'message' => 'Scraping job has been queued',
            'job_id' => $job->id,
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
        $job = Job::find($id);

        if (!$job) {
            return response()->json(['message' => 'Job not found'], Response::HTTP_NOT_FOUND);
        }

        $job->delete();

        return response()->json(['message' => 'Job deleted successfully'], Response::HTTP_OK);
    }
}

