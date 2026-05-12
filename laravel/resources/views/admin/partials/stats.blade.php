<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:24px;">
    <div class="stat-card">
        <div class="stat-label">Total Jobs</div>
        <div class="stat-value">{{ $stats['total_jobs'] }}</div>
        <div class="stat-sub">All indexed listings</div>
    </div>
    <div class="stat-card">
        <div class="stat-label" style="color:#065F46;">Active Listings</div>
        <div class="stat-value" style="color:#10B981;">{{ $stats['active_jobs'] }}</div>
        <div class="stat-sub">Live &amp; accepting</div>
    </div>
    <div class="stat-card">
        <div class="stat-label" style="color:#92400E;">Draft Jobs</div>
        <div class="stat-value" style="color:#F59E0B;">{{ $stats['draft_jobs'] }}</div>
        <div class="stat-sub">Pending review</div>
    </div>
    <div class="stat-card">
        <div class="stat-label" style="color:#1E40AF;">Remote Active</div>
        <div class="stat-value" style="color:#2563EB;">{{ $stats['remote_jobs'] }}</div>
        <div class="stat-sub">100% remote roles</div>
    </div>
</div>
