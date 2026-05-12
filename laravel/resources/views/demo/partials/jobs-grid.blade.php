<div id="jobs-grid" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(320px,1fr));gap:16px;">
    @forelse($jobs as $job)
    <a href="{{ route('demo.jobs.show', $job['id']) }}" style="display:block;background:white;border:1.5px solid #E2E8F0;border-radius:14px;padding:20px;text-decoration:none;color:#0F172A;transition:all .15s;box-shadow:0 1px 3px rgba(0,0,0,.06);" onmouseover="this.style.borderColor='#2563EB';this.style.boxShadow='0 4px 16px rgba(37,99,235,.12)'" onmouseout="this.style.borderColor='#E2E8F0';this.style.boxShadow='0 1px 3px rgba(0,0,0,.06)'">
        <div style="display:flex;align-items:flex-start;gap:12px;margin-bottom:14px;">
            <div style="width:44px;height:44px;border-radius:11px;background:{{ $job['logo_color'] }};color:white;display:flex;align-items:center;justify-content:center;font-size:0.8rem;font-weight:700;flex-shrink:0;">{{ $job['logo'] }}</div>
            <div style="flex:1;min-width:0;">
                <div style="font-weight:700;font-size:0.9rem;margin-bottom:2px;line-height:1.3;">{{ $job['title'] }}</div>
                <div style="font-size:0.78rem;color:#64748B;">{{ $job['company'] }}</div>
            </div>
            <div style="flex-shrink:0;text-align:center;">
                <div class="match-score {{ $job['match'] >= 90 ? 'high' : ($job['match'] >= 80 ? 'med' : 'low') }}" style="width:40px;height:40px;font-size:0.72rem;">{{ $job['match'] }}%</div>
                <div style="font-size:0.6rem;color:#94A3B8;margin-top:2px;">match</div>
            </div>
        </div>

        <div style="display:flex;flex-wrap:wrap;gap:6px;margin-bottom:14px;">
            <span style="display:flex;align-items:center;gap:4px;font-size:0.72rem;color:#64748B;"><i class="fa-solid fa-location-dot"></i> {{ $job['location'] }}</span>
            <span style="color:#CBD5E1;">·</span>
            @if($job['remote_type'] === 'remote')
                <span class="badge badge-green">Remote</span>
            @elseif($job['remote_type'] === 'hybrid')
                <span class="badge badge-blue">Hybrid</span>
            @else
                <span class="badge badge-slate">On-site</span>
            @endif
            <span style="color:#CBD5E1;">·</span>
            <span style="font-size:0.72rem;color:#64748B;">{{ $job['employment'] }}</span>
        </div>

        <div style="display:flex;flex-wrap:wrap;gap:5px;margin-bottom:14px;">
            @foreach($job['tags'] as $tag)
            <span style="background:#F1F5F9;color:#475569;border-radius:6px;padding:3px 9px;font-size:0.7rem;font-weight:500;">{{ $tag }}</span>
            @endforeach
        </div>

        <div style="display:flex;align-items:center;justify-content:space-between;border-top:1px solid #F1F5F9;padding-top:12px;">
            <span style="font-size:0.8rem;font-weight:600;color:#0F172A;">{{ $job['salary'] }}</span>
            <span style="font-size:0.7rem;color:#94A3B8;">{{ $job['posted'] }}</span>
        </div>
    </a>
    @empty
    <div style="grid-column:1/-1;text-align:center;padding:60px 20px;color:#94A3B8;">
        <i class="fa-solid fa-magnifying-glass" style="font-size:2rem;margin-bottom:12px;display:block;"></i>
        <div style="font-weight:600;font-size:0.9rem;color:#64748B;">No jobs found</div>
        <div style="font-size:0.8rem;margin-top:4px;">Try adjusting your search or filters</div>
    </div>
    @endforelse
</div>
