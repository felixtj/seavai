@extends('layouts.candidate-app')
@section('title', 'Dashboard — Seav.ai')
@section('page-title', 'Good morning, Sarah 👋')
@section('page-meta', now()->format('l, F j'))
@section('content')

<!-- Resume nudge banner (dismissible) -->
<div x-data="{ show: true }" x-show="show" style="display:flex;align-items:center;gap:12px;background:#FEF3C7;border:1px solid #FDE68A;border-radius:10px;padding:12px 16px;margin-bottom:24px;">
    <i class="fa-solid fa-triangle-exclamation" style="color:#F59E0B;flex-shrink:0;"></i>
    <div style="font-size:0.82rem;color:#92400E;flex:1;">
        <strong>Your resume isn't optimised yet.</strong> AI rewrite takes ~60 seconds and can boost your response rate by up to 3x.
    </div>
    <a href="{{ route('demo.resume') }}" class="btn btn-sm" style="background:#F59E0B;color:white;border:none;white-space:nowrap;">
        <i class="fa-solid fa-wand-magic-sparkles"></i> Optimise Now
    </a>
    <button @click="show = false" style="background:none;border:none;color:#92400E;cursor:pointer;padding:4px;opacity:.6;font-size:0.9rem;flex-shrink:0;">
        <i class="fa-solid fa-xmark"></i>
    </button>
</div>

<!-- Profile strength — slim inline bar -->
<div style="display:flex;align-items:center;gap:14px;margin-bottom:28px;">
    <div style="font-size:0.78rem;color:#64748B;white-space:nowrap;">Profile strength</div>
    <div class="progress-bar" style="flex:1;">
        <div class="progress-fill" style="width:72%;"></div>
    </div>
    <div style="font-size:0.78rem;font-weight:700;color:#2563EB;white-space:nowrap;">72%</div>
    <a href="{{ route('demo.resume') }}" style="font-size:0.72rem;color:#2563EB;text-decoration:none;white-space:nowrap;font-weight:600;">+ Optimise resume</a>
</div>

<!-- Top matches — full width, prominent -->
<div class="card">
    <div style="display:flex;align-items:center;justify-content:space-between;padding:20px 24px 16px;">
        <div>
            <div style="font-weight:700;font-size:1rem;">Your Top Matches This Week</div>
            <div style="font-size:0.75rem;color:#64748B;margin-top:2px;">Based on your profile · Updated Monday</div>
        </div>
        <a href="{{ route('demo.matches') }}" class="btn btn-outline btn-sm">View all <i class="fa-solid fa-arrow-right"></i></a>
    </div>
    <div style="padding:0 24px 24px;display:flex;flex-direction:column;gap:12px;">
        @foreach($jobs as $job)
        <a href="{{ route('demo.jobs.show', $job['id']) }}" style="display:flex;align-items:center;gap:16px;padding:16px;border:1.5px solid #E2E8F0;border-radius:12px;text-decoration:none;color:#0F172A;transition:all .15s;" onmouseover="this.style.borderColor='#2563EB';this.style.background='#F8FAFC'" onmouseout="this.style.borderColor='#E2E8F0';this.style.background='white'">
            <div style="width:46px;height:46px;border-radius:11px;background:{{ $job['logo_color'] }};color:white;display:flex;align-items:center;justify-content:center;font-size:0.8rem;font-weight:700;flex-shrink:0;">{{ $job['logo'] }}</div>
            <div style="flex:1;min-width:0;">
                <div style="font-weight:600;font-size:0.9rem;margin-bottom:3px;">{{ $job['title'] }}</div>
                <div style="font-size:0.78rem;color:#64748B;">
                    {{ $job['company'] }} · {{ $job['location'] }}
                    @if($job['remote_type']==='remote') <span class="badge badge-green" style="margin-left:4px;">Remote</span>
                    @elseif($job['remote_type']==='hybrid') <span class="badge badge-blue" style="margin-left:4px;">Hybrid</span>
                    @endif
                </div>
                <div style="font-size:0.75rem;color:#94A3B8;margin-top:3px;">{{ $job['salary'] }}</div>
            </div>
            <div style="text-align:center;flex-shrink:0;">
                <div class="match-score {{ $job['match'] >= 90 ? 'high' : ($job['match'] >= 80 ? 'med' : 'low') }}" style="width:50px;height:50px;font-size:0.82rem;">{{ $job['match'] }}%</div>
                <div style="font-size:0.62rem;color:#94A3B8;margin-top:3px;font-weight:600;">MATCH</div>
            </div>
        </a>
        @endforeach
    </div>

    <!-- Browse more footer -->
    <div style="padding:14px 24px;border-top:1px solid #F1F5F9;display:flex;align-items:center;justify-content:space-between;background:#FAFBFC;border-radius:0 0 14px 14px;">
        <span style="font-size:0.78rem;color:#64748B;">6 more matches waiting for you</span>
        <a href="{{ route('demo.jobs') }}" class="btn btn-primary btn-sm"><i class="fa-solid fa-briefcase"></i> Browse All Jobs</a>
    </div>
</div>

@endsection
