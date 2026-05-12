<!-- Toolbar -->
<div style="padding:14px 24px;background:white;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:12px;flex-wrap:wrap;position:sticky;top:64px;z-index:30;">

    <div style="display:flex;gap:6px;align-items:center;">
        @foreach(['all' => 'All', 'active' => 'Active', 'draft' => 'Draft', 'closed' => 'Closed'] as $val => $label)
        <button class="filter-chip {{ ($filter ?? 'all') === $val ? 'active' : '' }}"
                hx-get="{{ route('admin.jobs', ['filter' => $val, 'search' => $search ?? '']) }}"
                hx-target="#jobs-table"
                hx-swap="outerHTML"
                hx-push-url="true">
            {{ $label }}
        </button>
        @endforeach
    </div>

    <div style="color:var(--border);font-size:1.2rem;">|</div>

    <div style="position:relative;">
        <i class="fa-solid fa-magnifying-glass" style="position:absolute;left:10px;top:50%;transform:translateY(-50%);color:var(--text-light);font-size:0.8rem;"></i>
        <input type="text"
               class="search-input"
               placeholder="Search jobs, companies…"
               name="search"
               value="{{ $search ?? '' }}"
               hx-get="{{ route('admin.jobs', ['filter' => $filter ?? 'all']) }}"
               hx-target="#jobs-table"
               hx-swap="outerHTML"
               hx-trigger="keyup changed delay:350ms"
               hx-include="[name='search']"
               hx-push-url="true">
    </div>

    <div style="margin-left:auto;display:flex;gap:8px;">
        <span id="htmx-loading" class="htmx-indicator" style="font-size:0.78rem;color:var(--text-muted);align-items:center;gap:6px;">
            <i class="fa-solid fa-circle-notch fa-spin"></i> Filtering…
        </span>
        <button class="btn btn-primary btn-sm" @click="toast('Add Job — coming soon!')">
            <i class="fa-solid fa-plus"></i> Add Job
        </button>
    </div>
</div>

@include('admin.partials.jobs-table')
