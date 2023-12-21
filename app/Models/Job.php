<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable = ['urls', 'selectors', 'scraped_data'];

    protected $casts = [
        'urls' => 'array',
        'selectors' => 'array',
        'scraped_data' => 'array'
    ];
}

