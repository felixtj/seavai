<div id="jobs-table" hx-indicator="#htmx-loading">
    @if($jobs->isEmpty())
    <div style="padding:60px;text-align:center;color:var(--text-muted);">
        <i class="fa-solid fa-briefcase-blank" style="font-size:2rem;margin-bottom:12px;display:block;opacity:0.3;"></i>
        <p style="font-size:0.9rem;">No jobs found for this filter.</p>
    </div>
    @else
    <div class="card" style="margin:20px 24px;border-radius:12px;overflow:hidden;">
        <div class="card-header">
            <h3>
                @if(($filter ?? 'all') === 'all')
                    All Jobs
                @else
                    {{ ucfirst($filter) }} Jobs
                @endif
                <span style="font-weight:400;color:var(--text-muted);font-size:0.8rem;margin-left:6px;">({{ $jobs->total() }})</span>
            </h3>
            <span style="font-size:0.75rem;color:var(--text-muted);">Click a row to view details · Click status badge to cycle</span>
        </div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Job Title</th>
                    <th>Company</th>
                    <th>Location</th>
                    <th>Remote</th>
                    <th>Category</th>
                    <th>Salary (AUD)</th>
                    <th>Status</th>
                    <th>Posted</th>
                </tr>
            </thead>
            <tbody>
                @foreach($jobs as $job)
                <tr hx-get="{{ route('admin.jobs.drawer', $job) }}"
                    hx-target="#drawer-body"
                    hx-swap="innerHTML"
                    @click="openDrawer()"
                    style="cursor:pointer;">
                    <td>
                        <div style="font-weight:600;">{{ $job->title }}</div>
                        <div style="font-size:0.7rem;color:var(--text-muted);">{{ $job->source_domain }}</div>
                    </td>
                    <td>{{ $job->company }}</td>
                    <td style="color:var(--text-muted);">{{ $job->location }}</td>
                    <td>
                        @if($job->remote_type === 'remote')
                            <span class="badge badge-emerald"><i class="fa-solid fa-wifi" style="font-size:0.6rem;"></i> Remote</span>
                        @elseif($job->remote_type === 'hybrid')
                            <span class="badge badge-blue">Hybrid</span>
                        @else
                            <span class="badge badge-slate">Onsite</span>
                        @endif
                    </td>
                    <td>
                        @php
                        $catColors = ['tech' => 'badge-purple', 'digital-marketing' => 'badge-blue', 'ai-crypto' => 'badge-teal'];
                        $catLabels = ['tech' => 'Tech', 'digital-marketing' => 'Marketing', 'ai-crypto' => 'AI / Crypto'];
                        @endphp
                        <span class="badge {{ $catColors[$job->category] ?? 'badge-slate' }}">
                            {{ $catLabels[$job->category] ?? $job->category }}
                        </span>
                    </td>
                    <td style="font-size:0.78rem;">
                        @if($job->salary_min)
                            ${{ number_format($job->salary_min / 1000) }}k–${{ number_format($job->salary_max / 1000) }}k
                        @else
                            <span style="color:var(--text-light);">—</span>
                        @endif
                    </td>
                    <td @click.stop>
                        @include('admin.partials.status-badge', ['job' => $job])
                    </td>
                    <td style="color:var(--text-muted);font-size:0.75rem;white-space:nowrap;">{{ $job->posted_at?->diffForHumans() }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="pagination-wrap">
            <span>Showing {{ $jobs->firstItem() }}–{{ $jobs->lastItem() }} of {{ $jobs->total() }}</span>
            <div class="pagination-links">
                @if($jobs->onFirstPage())
                    <span style="opacity:0.4;">&laquo;</span>
                @else
                    <a hx-get="{{ $jobs->previousPageUrl() }}&filter={{ $filter ?? 'all' }}&search={{ $search ?? '' }}"
                       hx-target="#jobs-table"
                       hx-swap="outerHTML"
                       hx-push-url="true"
                       style="cursor:pointer;">&laquo;</a>
                @endif

                @foreach($jobs->getUrlRange(1, $jobs->lastPage()) as $page => $url)
                    @if($page == $jobs->currentPage())
                        <span class="active-page">{{ $page }}</span>
                    @else
                        <a hx-get="{{ $url }}&filter={{ $filter ?? 'all' }}&search={{ $search ?? '' }}"
                           hx-target="#jobs-table"
                           hx-swap="outerHTML"
                           hx-push-url="true"
                           style="cursor:pointer;">{{ $page }}</a>
                    @endif
                @endforeach

                @if($jobs->hasMorePages())
                    <a hx-get="{{ $jobs->nextPageUrl() }}&filter={{ $filter ?? 'all' }}&search={{ $search ?? '' }}"
                       hx-target="#jobs-table"
                       hx-swap="outerHTML"
                       hx-push-url="true"
                       style="cursor:pointer;">&raquo;</a>
                @else
                    <span style="opacity:0.4;">&raquo;</span>
                @endif
            </div>
        </div>
    </div>
    @endif
</div>
