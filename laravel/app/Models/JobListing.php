<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobListing extends Model
{
    protected $fillable = [
        'title', 'company', 'location', 'remote_type', 'status',
        'employment_type', 'salary_min', 'salary_max', 'category',
        'description', 'source_url', 'source_domain', 'posted_at',
    ];

    protected $casts = [
        'posted_at' => 'datetime',
    ];
}
