<?php

namespace App\Observers;

use App\Models\CandidateProfile;
use App\Models\User;

class UserObserver
{
    public function created(User $user): void
    {
        CandidateProfile::create([
            'user_id'          => $user->id,
            'onboarding_step'  => 0,
            'profile_completeness' => 0,
            'currency'         => 'AUD',
        ]);
    }
}
