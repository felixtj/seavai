<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureOnboardingComplete
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user) {
            $profile = $user->candidateProfile;

            if (!$profile || !$profile->onboarding_completed_at) {
                if (!$request->routeIs('onboarding*') && !$request->routeIs('logout')) {
                    return redirect()->route('onboarding');
                }
            }
        }

        return $next($request);
    }
}
