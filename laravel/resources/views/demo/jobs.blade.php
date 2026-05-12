@extends('layouts.candidate-app')
@section('title', 'Browse Jobs — Seav.ai')
@section('content')

<div class="page-header">
    <h1>Browse Jobs</h1>
    <p>{{ count($jobs) }} roles matching your profile · Updated today</p>
</div>

<!-- Filters bar -->
<div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;flex-wrap:wrap;">
    <!-- Filter chips -->
    <div style="display:flex;gap:6px;flex-wrap:wrap;">
        @foreach(['all' => 'All Jobs', 'remote' => 'Remote', 'hybrid' => 'Hybrid'] as $key => $label)
        <button
            hx-get="{{ route('demo.jobs', ['filter' => $key, 'search' => $search]) }}"
            hx-target="#jobs-grid"
            hx-swap="outerHTML"
            hx-push-url="{{ route('demo.jobs', ['filter' => $key]) }}"
            style="padding:7px 16px;border-radius:999px;font-size:0.78rem;font-weight:600;cursor:pointer;border:2px solid;transition:all .15s;font-family:inherit;
                {{ $filter === $key ? 'background:#EFF6FF;border-color:#2563EB;color:#1E40AF;' : 'background:white;border-color:#E2E8F0;color:#64748B;' }}"
        >{{ $label }}</button>
        @endforeach
    </div>

    <!-- Spacer -->
    <div style="flex:1;"></div>

    <!-- Search -->
    <div style="position:relative;">
        <i class="fa-solid fa-magnifying-glass" style="position:absolute;left:11px;top:50%;transform:translateY(-50%);color:#94A3B8;font-size:0.78rem;"></i>
        <input
            type="text"
            name="search"
            value="{{ $search }}"
            placeholder="Search jobs or companies…"
            hx-get="{{ route('demo.jobs', ['filter' => $filter]) }}"
            hx-trigger="keyup changed delay:300ms"
            hx-target="#jobs-grid"
            hx-swap="outerHTML"
            hx-include="[name='search']"
            style="padding:8px 14px 8px 32px;border:1.5px solid #E2E8F0;border-radius:8px;font-size:0.82rem;outline:none;font-family:inherit;width:240px;background:white;"
            onfocus="this.style.borderColor='#2563EB'"
            onblur="this.style.borderColor='#E2E8F0'"
        >
    </div>

    <!-- Sort (static demo) -->
    <select style="padding:8px 14px;border:1.5px solid #E2E8F0;border-radius:8px;font-size:0.82rem;color:#0F172A;background:white;outline:none;font-family:inherit;cursor:pointer;">
        <option>Best match</option>
        <option>Most recent</option>
        <option>Highest salary</option>
    </select>
</div>

<!-- Jobs grid (HTMX-swappable) -->
@include('demo.partials.jobs-grid', compact('jobs', 'filter', 'search'))

@endsection
