<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Models\CandidateSkill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OnboardingController extends Controller
{
    public function show()
    {
        $profile = Auth::user()->candidateProfile;

        if ($profile->onboarding_completed_at) {
            return redirect()->route('dashboard');
        }

        $step = max(1, $profile->onboarding_step + 1);
        $step = min(5, $step);

        return view('onboarding.wizard', compact('profile', 'step'));
    }

    public function save(Request $request, int $step)
    {
        $profile = Auth::user()->candidateProfile;

        match ($step) {
            1 => $this->saveStep1($request, $profile),
            2 => $this->saveStep2($request, $profile),
            3 => $this->saveStep3($request, $profile),
            4 => $this->saveStep4($request, $profile),
            5 => $this->saveStep5($request, $profile),
        };

        $profile->recalculateCompleteness();

        $nextStep = $step + 1;

        if ($nextStep > 5) {
            $profile->update(['onboarding_completed_at' => now()]);
            return response('<div id="onboarding-body" hx-get="/dashboard" hx-trigger="load" hx-target="body"></div>')
                ->header('HX-Redirect', route('dashboard'));
        }

        return view('onboarding.partials.step', [
            'profile' => $profile->fresh(),
            'step'    => $nextStep,
        ]);
    }

    public function back(Request $request, int $step)
    {
        $profile = Auth::user()->candidateProfile;
        $prevStep = max(1, $step - 1);

        return view('onboarding.partials.step', [
            'profile' => $profile,
            'step'    => $prevStep,
        ]);
    }

    private function saveStep1(Request $request, $profile): void
    {
        $data = $request->validate([
            'role_focus' => ['required', 'in:digital-marketing,tech,ai-crypto'],
        ]);
        $profile->update(array_merge($data, ['onboarding_step' => 1]));
    }

    private function saveStep2(Request $request, $profile): void
    {
        $data = $request->validate([
            'location'          => ['required', 'string', 'max:100'],
            'remote_preference' => ['required', 'in:remote,hybrid,onsite,flexible'],
            'seniority'         => ['required', 'in:junior,mid,senior,lead,any'],
            'salary_min'        => ['nullable', 'integer', 'min:0'],
            'salary_max'        => ['nullable', 'integer', 'min:0'],
        ]);
        $profile->update(array_merge($data, ['onboarding_step' => 2]));
    }

    private function saveStep3(Request $request, $profile): void
    {
        // Resume upload — handled by ResumeController; this step just advances
        $data = $request->validate([
            'linkedin_url' => ['nullable', 'url', 'max:255'],
        ]);
        $profile->update(array_merge($data, ['onboarding_step' => 3]));
    }

    private function saveStep4(Request $request, $profile): void
    {
        $request->validate([
            'skills' => ['nullable', 'string'],
        ]);

        $raw = $request->input('skills', '');
        $skills = array_filter(array_map('trim', explode(',', $raw)));

        // Replace all manual skills
        $profile->skills()->where('source', 'manual')->delete();

        foreach (array_unique($skills) as $skill) {
            if (strlen($skill) > 0 && strlen($skill) <= 60) {
                CandidateSkill::create([
                    'candidate_profile_id' => $profile->id,
                    'skill'                => $skill,
                    'source'               => 'manual',
                ]);
            }
        }

        $profile->update(['onboarding_step' => 4]);
    }

    private function saveStep5(Request $request, $profile): void
    {
        // marketing_opt_in lives on the user, not the profile
        Auth::user()->update([
            'marketing_opt_in' => $request->boolean('marketing_opt_in'),
        ]);
        $profile->update(['onboarding_step' => 5]);
    }
}
