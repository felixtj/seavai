<span class="badge {{ $job->status === 'active' ? 'badge-emerald' : ($job->status === 'draft' ? 'badge-amber' : 'badge-rose') }}"
      style="cursor:pointer;"
      hx-patch="{{ route('admin.jobs.status', $job) }}"
      hx-swap="outerHTML"
      title="Click to cycle status">
    {{ ucfirst($job->status) }}
</span>
