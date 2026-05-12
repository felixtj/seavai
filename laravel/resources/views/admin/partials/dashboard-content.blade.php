<div class="page-content">

    <div style="margin-bottom:22px;">
        <h1 style="font-size:1.2rem;font-weight:700;">Good morning, Admin 👋</h1>
        <p style="color:var(--text-muted);font-size:0.85rem;margin-top:3px;">{{ now()->format('F j, Y') }} · Here's your platform overview</p>
    </div>

    <!-- Stats — lazy loaded via HTMX -->
    <div hx-get="{{ route('admin.dashboard.stats') }}"
         hx-trigger="load"
         hx-swap="outerHTML">
        <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:24px;">
            @for($i = 0; $i < 4; $i++)
            <div class="stat-card" style="opacity:0.4;">
                <div class="stat-label" style="background:#e2e8f0;width:80px;height:12px;border-radius:4px;">&nbsp;</div>
                <div class="stat-value" style="background:#e2e8f0;width:60px;height:28px;border-radius:4px;margin-top:8px;">&nbsp;</div>
            </div>
            @endfor
        </div>
    </div>

    <!-- Funnel -->
    <div style="margin-bottom:8px;font-size:0.78rem;font-weight:600;color:var(--text-muted);">Job pipeline</div>
    <div class="funnel-wrap" style="margin-bottom:28px;">
        <div class="funnel-step">
            <div class="fs-num" style="color:#64748B;">{{ $stats['total_jobs'] }}</div>
            <div class="fs-lbl">Total Jobs</div>
            <div class="fs-bar" style="background:#E2E8F0;"></div>
        </div>
        <div class="funnel-arrow"><i class="fa-solid fa-chevron-right"></i></div>
        <div class="funnel-step">
            <div class="fs-num" style="color:#2563EB;">{{ $stats['active_jobs'] }}</div>
            <div class="fs-lbl">Active</div>
            <div class="fs-bar" style="background:#DBEAFE;"></div>
        </div>
        <div class="funnel-arrow"><i class="fa-solid fa-chevron-right"></i></div>
        <div class="funnel-step">
            <div class="fs-num" style="color:#F59E0B;">{{ $stats['draft_jobs'] }}</div>
            <div class="fs-lbl">Draft</div>
            <div class="fs-bar" style="background:#FEF3C7;"></div>
        </div>
        <div class="funnel-arrow"><i class="fa-solid fa-chevron-right"></i></div>
        <div class="funnel-step">
            <div class="fs-num" style="color:#10B981;">{{ $stats['remote_jobs'] }}</div>
            <div class="fs-lbl">Remote Active</div>
            <div class="fs-bar" style="background:#D1FAE5;"></div>
        </div>
    </div>

    <!-- Recent Jobs + Activity -->
    <div style="display:grid;grid-template-columns:1fr 300px;gap:20px;">

        <div class="card">
            <div class="card-header">
                <h3>Recent Job Listings</h3>
                <button class="btn btn-secondary btn-sm"
                        hx-get="{{ route('admin.jobs') }}"
                        hx-target="#main-content"
                        hx-push-url="{{ route('admin.jobs') }}">
                    View All <i class="fa-solid fa-arrow-right"></i>
                </button>
            </div>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Job / Company</th>
                        <th>Location</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Posted</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentJobs as $job)
                    <tr hx-get="{{ route('admin.jobs.drawer', $job) }}"
                        hx-target="#drawer-body"
                        hx-swap="innerHTML"
                        @click="openDrawer()"
                        style="cursor:pointer;">
                        <td>
                            <div style="font-weight:600;font-size:0.82rem;">{{ $job->title }}</div>
                            <div style="font-size:0.72rem;color:var(--text-muted);">{{ $job->company }}</div>
                        </td>
                        <td style="color:var(--text-muted);">{{ $job->location }}</td>
                        <td>
                            @if($job->remote_type === 'remote')
                                <span class="badge badge-emerald">Remote</span>
                            @elseif($job->remote_type === 'hybrid')
                                <span class="badge badge-blue">Hybrid</span>
                            @else
                                <span class="badge badge-slate">Onsite</span>
                            @endif
                        </td>
                        <td>@include('admin.partials.status-badge', ['job' => $job])</td>
                        <td style="color:var(--text-muted);">{{ $job->posted_at?->diffForHumans() }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="card">
            <div class="card-header"><h3>Activity</h3></div>
            <div class="card-body">
                @php
                $activities = [
                    ['icon' => 'fa-plus',                 'color' => '#2563EB', 'bg' => '#EFF6FF', 'text' => 'New job indexed',       'sub' => 'Canva · Sydney',       'time' => '2m ago'],
                    ['icon' => 'fa-rotate',               'color' => '#10B981', 'bg' => '#D1FAE5', 'text' => 'Job refreshed',          'sub' => 'Atlassian · Remote',   'time' => '14m ago'],
                    ['icon' => 'fa-xmark',                'color' => '#EF4444', 'bg' => '#FEE2E2', 'text' => 'Job closed',             'sub' => 'Afterpay · Melbourne', 'time' => '1h ago'],
                    ['icon' => 'fa-plus',                 'color' => '#2563EB', 'bg' => '#EFF6FF', 'text' => '3 new jobs indexed',     'sub' => 'REA Group',            'time' => '2h ago'],
                    ['icon' => 'fa-triangle-exclamation', 'color' => '#F59E0B', 'bg' => '#FEF3C7', 'text' => 'Connector warning',      'sub' => 'SEEK source',          'time' => '3h ago'],
                ];
                @endphp
                @foreach($activities as $i => $act)
                <div style="display:flex;gap:10px;padding:10px 0;{{ $i < count($activities)-1 ? 'border-bottom:1px solid var(--border);' : '' }}">
                    <div style="width:30px;height:30px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:0.75rem;flex-shrink:0;background:{{ $act['bg'] }};color:{{ $act['color'] }};">
                        <i class="fa-solid {{ $act['icon'] }}"></i>
                    </div>
                    <div style="flex:1;min-width:0;">
                        <strong style="font-size:0.78rem;font-weight:600;display:block;">{{ $act['text'] }}</strong>
                        <span style="font-size:0.72rem;color:var(--text-muted);">{{ $act['sub'] }}</span>
                    </div>
                    <span style="font-size:0.68rem;color:var(--text-light);flex-shrink:0;">{{ $act['time'] }}</span>
                </div>
                @endforeach
            </div>
        </div>

    </div>

</div>
