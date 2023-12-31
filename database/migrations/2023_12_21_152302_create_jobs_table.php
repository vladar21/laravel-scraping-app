<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->json('urls'); // Storing array of URLs
            $table->json('selectors'); // HTML/CSS selectors
            $table->json('scraped_data')->nullable(); // Store the scraped data
            $table->string('status')->default('queued'); // Add a status field
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
