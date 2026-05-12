@extends('layouts.candidate-app')
@section('title', 'My Matches — Seav.ai')
@section('content')

<div class="page-header" style="display:flex;align-items:flex-start;justify-content:space-between;">
    <div>
        <h1>Weekly Pulse Check</h1>
        <p>Curated matches just for you · Refreshed Monday</p>
    </div>
    <div style="background:linear-gradient(135deg,#1e40af,#2563eb);border-radius:12px;padding:12px 18px;color:white;text-align:right;">
        <div style="font-size:0.7rem;opacity:.8;font-weight:600;text-transform:uppercase;letter-spacing:.05em;">This week</div>
        <div style="font-size:1.5rem;font-weight:800;line-height:1;">{{ count($jobs) }}</div>
        <div style="font-size:0.72rem;opacity:.85;">new matches</div>
    </div>
</div>

<!-- Match quality bar -->
<div class="card card-pad" style="margin-bottom:24px;">
    <div style="display:flex;align-items:center;gap:24px;flex-wrap:wrap;">
        <div>
            <div style="font-size:0.72rem;font-weight:700;color:#94A3B8;text-transform:uppercase;letter-spacing:.05em;margin-bottom:4px;">Match quality this week</div>
            <div style="display:flex;align-items:center;gap:8px;">
                <div class="progress-bar" style="width:200px;height:8px;">
                    <div class="progress-fill" style="width:87%;background:linear-gradient(90deg,#10B981,#2563EB);"></div>
                </div>
                <span style="font-weight:700;font-size:0.875rem;color:#2563EB;">87%</span>
                <span style="font-size:0.75rem;color:#64748B;">avg match score</span>
            </div>
        </div>
        <div style="margin-left:auto;display:flex;gap:16px;">
            @foreach([['high','90%+','#065F46','#D1FAE5',1],['med','80–89%','#1E40AF','#DBEAFE',3],['low','70–79%','#92400E','#FEF3C7',2]] as $tier)
            <div style="text-align:center;">
                <div style="font-size:1.1rem;font-weight:800;color:{{ $tier[2] }};">{{ $tier[4] }}</div>
                <div style="font-size:0.65rem;color:{{ $tier[2] }};background:{{ $tier[3] }};padding:2px 8px;border-radius:999px;font-weight:600;">{{ $tier[1] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Match cards grid -->
<div style="display:flex;flex-direction:column;gap:14px;">
    @foreach($jobs as $i => $job)
    <div class="card" style="overflow:hidden;transition:box-shadow .15s;" onmouseover="this.style.boxShadow='0 4px 20px rgba(37,99,235,.12)'" onmouseout="this.style.boxShadow=''">
        <div style="display:flex;align-items:stretch;">

            <!-- Match score sidebar -->
            <div style="width:6px;background:{{ $job['match'] >= 90 ? '#10B981' : ($job['match'] >= 80 ? '#2563EB' : '#F59E0B') }};flex-shrink:0;border-radius:14px 0 0 14px;"></div>

            <!-- Main content -->
            <div style="flex:1;padding:18px 20px;min-width:0;">
                <div style="display:flex;align-items:flex-start;gap:14px;">

                    <!-- Company logo -->
                    <div style="width:46px;height:46px;border-radius:12px;background:{{ $job['logo_color'] }};color:white;display:flex;align-items:center;justify-content:center;font-size:0.82rem;font-weight:700;flex-shrink:0;">{{ $job['logo'] }}</div>

                    <!-- Job info -->
                    <div style="flex:1;min-width:0;">
                        <div style="display:flex;align-items:center;gap:8px;margin-bottom:2px;flex-wrap:wrap;">
                            <a href="{{ route('demo.jobs.show', $job['id']) }}" style="font-weight:700;font-size:0.95rem;color:#0F172A;text-decoration:none;" onmouseover="this.style.color='#2563EB'" onmouseout="this.style.color='#0F172A'">{{ $job['title'] }}</a>
                            @if($i === 0)<span style="background:#FEF3C7;color:#92400E;font-size:0.65rem;font-weight:700;padding:2px 7px;border-radius:4px;">TOP PICK</span>@endif
                            @if($i === 1)<span style="background:#EDE9FE;color:#5B21B6;font-size:0.65rem;font-weight:700;padding:2px 7px;border-radius:4px;">TRENDING</span>@endif
                        </div>
                        <div style="font-size:0.82rem;color:#64748B;margin-bottom:8px;">{{ $job['company'] }}</div>
                        <div style="display:flex;flex-wrap:wrap;gap:10px;font-size:0.75rem;color:#64748B;">
                            <span><i class="fa-solid fa-location-dot" style="color:#94A3B8;margin-right:3px;"></i>{{ $job['location'] }}</span>
                            <span><i class="fa-solid fa-dollar-sign" style="color:#94A3B8;margin-right:3px;"></i>{{ $job['salary'] }}</span>
                            @if($job['remote_type'] === 'remote')
                                <span class="badge badge-green">Remote</span>
                            @elseif($job['remote_type'] === 'hybrid')
                                <span class="badge badge-blue">Hybrid</span>
                            @else
                                <span class="badge badge-slate">On-site</span>
                            @endif
                        </div>
                    </div>

                    <!-- Match score + actions -->
                    <div style="display:flex;flex-direction:column;align-items:flex-end;gap:10px;flex-shrink:0;">
                        <div style="text-align:center;">
                            <div class="match-score {{ $job['match'] >= 90 ? 'high' : ($job['match'] >= 80 ? 'med' : 'low') }}" style="width:48px;height:48px;font-size:0.82rem;">{{ $job['match'] }}%</div>
                            <div style="font-size:0.6rem;color:#94A3B8;margin-top:3px;font-weight:600;">MATCH</div>
                        </div>
                        <div style="display:flex;gap:6px;">
                            <a href="{{ route('demo.jobs.show', $job['id']) }}" class="btn btn-primary btn-sm">Apply</a>
                            <button class="btn btn-ghost btn-sm" title="Save"><i class="fa-regular fa-bookmark"></i></button>
                        </div>
                    </div>

                </div>

                <!-- Why it matches -->
                <div style="margin-top:14px;padding-top:14px;border-top:1px solid #F1F5F9;display:flex;align-items:flex-start;gap:8px;">
                    <span style="font-size:0.72rem;font-weight:700;color:#94A3B8;text-transform:uppercase;letter-spacing:.05em;flex-shrink:0;margin-top:1px;">Why matched</span>
                    <div style="display:flex;flex-wrap:wrap;gap:6px;">
                        @foreach($job['tags'] as $tag)
                        <span style="background:#F0FDF4;border:1px solid #BBF7D0;border-radius:6px;padding:2px 8px;font-size:0.7rem;font-weight:600;color:#065F46;"><i class="fa-solid fa-check" style="font-size:0.6rem;margin-right:3px;"></i>{{ $tag }}</span>
                        @endforeach
                        <span style="background:#EFF6FF;border:1px solid #BFDBFE;border-radius:6px;padding:2px 8px;font-size:0.7rem;font-weight:600;color:#1E40AF;"><i class="fa-solid fa-check" style="font-size:0.6rem;margin-right:3px;"></i>Salary range</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Upgrade CTA at bottom -->
<div style="margin-top:28px;background:linear-gradient(135deg,#0F172A,#1e3a8a);border-radius:16px;padding:32px;color:white;display:flex;align-items:center;gap:32px;flex-wrap:wrap;">
    <div style="flex:1;min-width:200px;">
        <div style="font-size:1.4rem;margin-bottom:8px;">⚡</div>
        <h3 style="font-size:1.1rem;font-weight:800;margin:0 0 8px;">Get Pulse Check Pro</h3>
        <p style="font-size:0.85rem;opacity:.8;margin:0;line-height:1.6;">Unlock daily role alerts, salary benchmarks for each match, hidden job access from company career pages, and a dedicated AI job coach session each week.</p>
    </div>
    <div style="display:flex;flex-direction:column;gap:10px;min-width:180px;">
        <a href="#" style="display:block;background:white;color:#1E40AF;text-align:center;padding:12px 24px;border-radius:9px;font-weight:700;font-size:0.875rem;text-decoration:none;">Start Free Trial</a>
        <div style="text-align:center;font-size:0.72rem;opacity:.6;">No credit card · Cancel anytime</div>
    </div>
</div>

@endsection
