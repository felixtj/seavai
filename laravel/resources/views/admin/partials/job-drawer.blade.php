<div class="drawer-header">
    <div class="drawer-header-left">
        <h2>{{ $job->title }}</h2>
        <div class="dmeta">
            <span><i class="fa-solid fa-building" style="margin-right:4px;"></i>{{ $job->company }}</span>
            <span>·</span>
            <span><i class="fa-solid fa-location-dot" style="margin-right:4px;"></i>{{ $job->location }}</span>
            <span>·</span>
            @include('admin.partials.status-badge', ['job' => $job])
        </div>
    </div>
    <button class="drawer-close" @click="closeDrawer()">
        <i class="fa-solid fa-xmark"></i>
    </button>
</div>

<div class="drawer-body">

    <!-- Key Details -->
    <div class="drawer-section">
        <div class="dsection-title">Job Details</div>
        <div class="info-grid">
            <div class="info-item">
                <label>Remote Type</label>
                <span>
                    @if($job->remote_type === 'remote')
                        <span class="badge badge-emerald">Remote</span>
                    @elseif($job->remote_type === 'hybrid')
                        <span class="badge badge-blue">Hybrid</span>
                    @else
                        <span class="badge badge-slate">Onsite</span>
                    @endif
                </span>
            </div>
            <div class="info-item">
                <label>Employment</label>
                <span>{{ ucwords(str_replace('-', ' ', $job->employment_type)) }}</span>
            </div>
            <div class="info-item">
                <label>Salary Range</label>
                <span>
                    @if($job->salary_min)
                        ${{ number_format($job->salary_min) }} – ${{ number_format($job->salary_max) }}
                    @else
                        Not disclosed
                    @endif
                </span>
            </div>
            <div class="info-item">
                <label>Category</label>
                <span>{{ ucwords(str_replace('-', ' ', $job->category)) }}</span>
            </div>
            <div class="info-item">
                <label>Posted</label>
                <span>{{ $job->posted_at?->format('M j, Y') }} ({{ $job->posted_at?->diffForHumans() }})</span>
            </div>
            <div class="info-item">
                <label>Source</label>
                <span>{{ $job->source_domain }}</span>
            </div>
        </div>
    </div>

    <!-- Provenance / Trust -->
    <div class="drawer-section">
        <div class="dsection-title">Source Provenance</div>
        <div style="background:#F8FAFC;border:1px solid var(--border);border-radius:8px;padding:12px 14px;font-size:0.8rem;">
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:6px;">
                <i class="fa-solid fa-circle-check" style="color:#10B981;"></i>
                <span style="font-weight:600;">Fetched from company careers page</span>
            </div>
            <div style="color:var(--text-muted);font-size:0.75rem;margin-bottom:8px;">
                Source: <a href="{{ $job->source_url }}" target="_blank" style="color:var(--accent);">{{ $job->source_url }}</a>
            </div>
            <div style="display:flex;gap:8px;flex-wrap:wrap;">
                <span class="badge badge-emerald">Declared by employer</span>
                <span class="badge badge-blue">ATS-sourced</span>
            </div>
        </div>
    </div>

    <!-- Description -->
    <div class="drawer-section">
        <div class="dsection-title">Description</div>
        <p style="font-size:0.82rem;color:var(--text-muted);line-height:1.6;">{{ $job->description }}</p>
    </div>

    <!-- Admin Actions -->
    <div class="drawer-section">
        <div class="dsection-title">Admin Actions</div>
        <div style="display:flex;gap:8px;flex-wrap:wrap;">
            <button class="btn btn-secondary btn-sm" @click="toast('Edit job — coming soon!')">
                <i class="fa-solid fa-pen"></i> Edit
            </button>
            <button class="btn btn-secondary btn-sm" @click="toast('Re-fetch from source — coming soon!')">
                <i class="fa-solid fa-rotate"></i> Re-fetch
            </button>
            <button class="btn btn-sm" style="background:var(--danger-bg);border-color:#FECACA;color:#B91C1C;" @click="toast('Job flagged for review!')">
                <i class="fa-solid fa-flag"></i> Flag
            </button>
        </div>
    </div>

</div>

<div class="drawer-footer">
    <a href="{{ $job->source_url }}" target="_blank" class="btn btn-primary btn-sm">
        <i class="fa-solid fa-arrow-up-right-from-square"></i> View Original Posting
    </a>
    <button class="btn btn-secondary btn-sm" @click="closeDrawer()">Close</button>
</div>
