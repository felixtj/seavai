@extends('layouts.candidate-app')
@section('title', '{{ $job["title"] }} — Seav.ai')
@section('content')

@php
$descriptions = [
    1 => [
        'about'  => 'Canva is a global design platform used by over 150 million people. Our Sydney HQ is looking for a Senior Digital Marketing Manager to own APAC growth across organic and paid channels.',
        'resp'   => [
            'Own SEO and content strategy for APAC — driving organic growth across Australia, NZ, Japan, and Southeast Asia',
            'Manage $500k+ annual budget across Google, LinkedIn, Meta, and programmatic channels',
            'Partner with Product and Design to create integrated campaign briefs and landing page experiences',
            'Build and mentor a team of 3 marketing specialists',
            'Present monthly performance reports to VP Marketing and C-suite',
        ],
        'req'    => [
            '6+ years in digital marketing with at least 2 years in a leadership or senior IC role',
            'Deep expertise in SEO (technical + content), paid social, and SEM',
            'Strong analytical skills — comfortable in GA4, Looker, or similar BI tools',
            'Experience marketing a B2C or PLG SaaS product',
            'Excellent written and verbal communication',
        ],
        'perks'  => ['Equity package', 'Flexible hybrid (2 days office)', 'Generous L&D budget', 'Paid volunteer days', 'Team retreats'],
        'culture'=> 'Canva has a strong design-led culture with high autonomy and fast experimentation cycles. The marketing team is collaborative and data-obsessed.',
    ],
];
$desc = $descriptions[$job['id']] ?? [
    'about'  => 'This is an exciting opportunity to join a high-growth Australian tech company at a pivotal point in their expansion.',
    'resp'   => ['Lead digital marketing campaigns across paid and organic channels','Manage budgets and report on performance to leadership','Partner cross-functionally with Product and Sales','Build and mentor team members'],
    'req'    => ['5+ years digital marketing experience','Strong analytical background','Experience with SaaS or tech products','Excellent communication skills'],
    'perks'  => ['Flexible work arrangements', 'Learning & development budget', 'Health & wellbeing benefits'],
    'culture'=> 'A collaborative, high-performance culture with a focus on innovation and continuous learning.',
];
@endphp

<div x-data="{ applied: false, saved: false }">

<!-- Back link -->
<a href="{{ route('demo.jobs') }}" style="display:inline-flex;align-items:center;gap:6px;font-size:0.82rem;color:#64748B;text-decoration:none;margin-bottom:20px;" onmouseover="this.style.color='#2563EB'" onmouseout="this.style.color='#64748B'">
    <i class="fa-solid fa-arrow-left"></i> Back to jobs
</a>

<div style="display:grid;grid-template-columns:1fr 300px;gap:24px;align-items:start;">

    <!-- LEFT — Job detail -->
    <div>

        <!-- Header card -->
        <div class="card card-pad" style="margin-bottom:20px;">
            <div style="display:flex;align-items:flex-start;gap:16px;">
                <div style="width:56px;height:56px;border-radius:14px;background:{{ $job['logo_color'] }};color:white;display:flex;align-items:center;justify-content:center;font-size:1rem;font-weight:700;flex-shrink:0;">{{ $job['logo'] }}</div>
                <div style="flex:1;">
                    <h1 style="font-size:1.35rem;font-weight:700;margin:0 0 4px;">{{ $job['title'] }}</h1>
                    <div style="font-size:0.875rem;color:#64748B;margin-bottom:10px;">{{ $job['company'] }}</div>
                    <div style="display:flex;flex-wrap:wrap;gap:12px;font-size:0.78rem;color:#64748B;">
                        <span><i class="fa-solid fa-location-dot" style="color:#94A3B8;margin-right:4px;"></i>{{ $job['location'] }}</span>
                        <span><i class="fa-solid fa-briefcase" style="color:#94A3B8;margin-right:4px;"></i>{{ $job['employment'] }}</span>
                        <span><i class="fa-solid fa-dollar-sign" style="color:#94A3B8;margin-right:4px;"></i>{{ $job['salary'] }}</span>
                        @if($job['remote_type'] === 'remote')
                            <span class="badge badge-green"><i class="fa-solid fa-wifi"></i> Remote</span>
                        @elseif($job['remote_type'] === 'hybrid')
                            <span class="badge badge-blue"><i class="fa-solid fa-building"></i> Hybrid</span>
                        @else
                            <span class="badge badge-slate">On-site</span>
                        @endif
                    </div>
                </div>
                <div style="text-align:center;flex-shrink:0;">
                    <div class="match-score {{ $job['match'] >= 90 ? 'high' : ($job['match'] >= 80 ? 'med' : 'low') }}" style="width:52px;height:52px;font-size:0.85rem;">{{ $job['match'] }}%</div>
                    <div style="font-size:0.65rem;color:#94A3B8;margin-top:4px;font-weight:600;">AI MATCH</div>
                </div>
            </div>

            <!-- Tags -->
            <div style="display:flex;flex-wrap:wrap;gap:6px;margin-top:16px;padding-top:16px;border-top:1px solid #F1F5F9;">
                @foreach($job['tags'] as $tag)
                <span style="background:#F1F5F9;color:#475569;border-radius:7px;padding:4px 10px;font-size:0.72rem;font-weight:600;">{{ $tag }}</span>
                @endforeach
                <span style="font-size:0.72rem;color:#94A3B8;align-self:center;margin-left:auto;">Posted {{ $job['posted'] }}</span>
            </div>
        </div>

        <!-- About the role -->
        <div class="card card-pad" style="margin-bottom:16px;">
            <h2 style="font-size:0.8rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#94A3B8;margin-bottom:12px;">About the Role</h2>
            <p style="font-size:0.875rem;line-height:1.7;color:#374151;margin:0;">{{ $desc['about'] }}</p>
        </div>

        <!-- Responsibilities -->
        <div class="card card-pad" style="margin-bottom:16px;">
            <h2 style="font-size:0.8rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#94A3B8;margin-bottom:12px;">What You'll Do</h2>
            <ul style="margin:0;padding-left:18px;display:flex;flex-direction:column;gap:8px;">
                @foreach($desc['resp'] as $r)
                <li style="font-size:0.875rem;line-height:1.6;color:#374151;">{{ $r }}</li>
                @endforeach
            </ul>
        </div>

        <!-- Requirements -->
        <div class="card card-pad" style="margin-bottom:16px;">
            <h2 style="font-size:0.8rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#94A3B8;margin-bottom:12px;">What You'll Bring</h2>
            <ul style="margin:0;padding-left:18px;display:flex;flex-direction:column;gap:8px;">
                @foreach($desc['req'] as $r)
                <li style="font-size:0.875rem;line-height:1.6;color:#374151;">{{ $r }}</li>
                @endforeach
            </ul>
        </div>

        <!-- Perks -->
        <div class="card card-pad" style="margin-bottom:16px;">
            <h2 style="font-size:0.8rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#94A3B8;margin-bottom:12px;">Perks & Benefits</h2>
            <div style="display:flex;flex-wrap:wrap;gap:8px;">
                @foreach($desc['perks'] as $perk)
                <div style="display:flex;align-items:center;gap:6px;background:#F0FDF4;border:1px solid #BBF7D0;border-radius:8px;padding:6px 12px;font-size:0.78rem;color:#065F46;font-weight:500;">
                    <i class="fa-solid fa-check" style="font-size:0.65rem;"></i> {{ $perk }}
                </div>
                @endforeach
            </div>
        </div>

        <!-- Culture -->
        <div class="card card-pad" style="margin-bottom:16px;">
            <h2 style="font-size:0.8rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#94A3B8;margin-bottom:12px;">Culture</h2>
            <p style="font-size:0.875rem;line-height:1.7;color:#374151;margin:0;">{{ $desc['culture'] }}</p>
        </div>

    </div>

    <!-- RIGHT — Apply panel -->
    <div style="position:sticky;top:80px;display:flex;flex-direction:column;gap:16px;">

        <!-- Apply card -->
        <div class="card card-pad">

            <!-- Pre-apply state -->
            <div x-show="!applied">
                <div style="background:#EFF6FF;border:1px solid #BFDBFE;border-radius:10px;padding:12px 14px;margin-bottom:16px;">
                    <div style="display:flex;align-items:center;gap:8px;margin-bottom:4px;">
                        <div class="match-score {{ $job['match'] >= 90 ? 'high' : ($job['match'] >= 80 ? 'med' : 'low') }}" style="width:34px;height:34px;font-size:0.7rem;">{{ $job['match'] }}%</div>
                        <div>
                            <div style="font-weight:700;font-size:0.82rem;color:#1E40AF;">Strong Match</div>
                            <div style="font-size:0.72rem;color:#3B82F6;">Your profile aligns well</div>
                        </div>
                    </div>
                    <div style="font-size:0.72rem;color:#1E40AF;margin-top:8px;line-height:1.5;">Your SEO and paid media experience is a direct match. Consider adding quantified results to strengthen your application.</div>
                </div>

                <button @click="applied = true" class="btn btn-primary" style="width:100%;justify-content:center;font-size:0.875rem;padding:12px;">
                    <i class="fa-solid fa-paper-plane"></i> Apply with Seav.ai
                </button>
                <div style="text-align:center;font-size:0.7rem;color:#94A3B8;margin-top:8px;">Your resume + profile auto-attached</div>

                <div style="margin-top:14px;padding-top:14px;border-top:1px solid #F1F5F9;display:flex;gap:8px;">
                    <button @click="saved = !saved" :class="saved ? 'btn-primary' : 'btn-outline'" class="btn btn-sm" style="flex:1;justify-content:center;">
                        <i class="fa-solid fa-bookmark"></i>
                        <span x-text="saved ? 'Saved' : 'Save'"></span>
                    </button>
                    <button class="btn btn-outline btn-sm" style="flex:1;justify-content:center;"><i class="fa-solid fa-share-nodes"></i> Share</button>
                </div>
            </div>

            <!-- Post-apply state -->
            <div x-show="applied" style="display:none;text-align:center;padding:8px 0;">
                <div style="font-size:2rem;margin-bottom:10px;">🎉</div>
                <div style="font-weight:700;font-size:0.95rem;color:#065F46;margin-bottom:6px;">Application Sent!</div>
                <div style="font-size:0.78rem;color:#64748B;margin-bottom:16px;line-height:1.5;">Your profile and resume have been submitted to {{ $job['company'] }}. We'll notify you of any updates.</div>
                <div style="background:#F0FDF4;border:1px solid #BBF7D0;border-radius:8px;padding:10px;font-size:0.75rem;color:#065F46;text-align:left;margin-bottom:14px;">
                    <strong>Next step:</strong> {{ $job['company'] }} typically responds within 3–5 business days.
                </div>
                <a href="{{ route('demo.jobs') }}" class="btn btn-outline" style="width:100%;justify-content:center;">Browse More Jobs</a>
            </div>
        </div>

        <!-- AI tip -->
        <div class="card card-pad" style="background:linear-gradient(135deg,#F5F3FF,#EFF6FF);">
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:8px;">
                <span style="font-size:1rem;">✨</span>
                <div style="font-weight:700;font-size:0.82rem;color:#1E40AF;">AI Tip</div>
            </div>
            <div style="font-size:0.75rem;color:#475569;line-height:1.6;margin-bottom:12px;">Your resume doesn't yet show quantified results for your Canva role. Adding metrics could increase your callback rate by up to 2x.</div>
            <a href="{{ route('demo.resume') }}" class="btn btn-sm" style="background:#7C3AED;color:white;border:none;width:100%;justify-content:center;">Optimise Resume</a>
        </div>

        <!-- Similar roles -->
        <div class="card card-pad">
            <div style="font-size:0.72rem;font-weight:700;color:#94A3B8;text-transform:uppercase;letter-spacing:.05em;margin-bottom:12px;">Similar Roles</div>
            <div style="display:flex;flex-direction:column;gap:10px;">
                @foreach(array_slice(array_filter($jobs ?? [], fn($j) => $j['id'] !== $job['id']), 0, 3) as $similar)
                <a href="{{ route('demo.jobs.show', $similar['id']) }}" style="display:flex;align-items:center;gap:10px;text-decoration:none;color:#0F172A;padding:8px;border-radius:8px;transition:background .15s;" onmouseover="this.style.background='#F8FAFC'" onmouseout="this.style.background='none'">
                    <div style="width:32px;height:32px;border-radius:8px;background:{{ $similar['logo_color'] }};color:white;display:flex;align-items:center;justify-content:center;font-size:0.65rem;font-weight:700;flex-shrink:0;">{{ $similar['logo'] }}</div>
                    <div style="flex:1;min-width:0;">
                        <div style="font-size:0.78rem;font-weight:600;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $similar['title'] }}</div>
                        <div style="font-size:0.7rem;color:#64748B;">{{ $similar['company'] }}</div>
                    </div>
                    <div style="font-size:0.72rem;font-weight:700;color:{{ $similar['match'] >= 90 ? '#065F46' : ($similar['match'] >= 80 ? '#1E40AF' : '#92400E') }};">{{ $similar['match'] }}%</div>
                </a>
                @endforeach
            </div>
        </div>

    </div>
</div>

</div>

@endsection
