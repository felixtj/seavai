<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CandidateProfile extends Model
{
    protected $fillable = [
        'user_id',
        'role_focus',
        'location',
        'remote_preference',
        'seniority',
        'salary_min',
        'salary_max',
        'currency',
        'linkedin_url',
        'headline',
        'bio',
        'onboarding_step',
        'onboarding_completed_at',
        'profile_completeness',
    ];

    protected $casts = [
        'onboarding_completed_at' => 'datetime',
        'salary_min'              => 'integer',
        'salary_max'              => 'integer',
        'onboarding_step'         => 'integer',
        'profile_completeness'    => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function skills(): HasMany
    {
        return $this->hasMany(CandidateSkill::class);
    }

    public function recalculateCompleteness(): void
    {
        $score = 0;

        if ($this->role_focus)         $score += 20;
        if ($this->location)           $score += 15;
        if ($this->remote_preference)  $score += 10;
        if ($this->seniority)          $score += 10;
        if ($this->salary_min)         $score += 10;
        if ($this->skills()->exists()) $score += 20;
        if ($this->linkedin_url)       $score += 10;
        if ($this->headline)           $score += 5;

        $this->update(['profile_completeness' => min(100, $score)]);
    }
}
