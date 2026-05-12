@extends('layouts.auth')

@section('title', 'Get started — Seav.ai')

@section('content')
    <div class="text-center py-4">
        <div class="w-14 h-14 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-7 h-7 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <h1 class="text-2xl font-bold text-slate-900 mb-2">You're in!</h1>
        <p class="text-slate-500 text-sm mb-6">Onboarding wizard coming soon.</p>
        <a href="{{ route('dashboard') }}"
           class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg px-6 py-2.5 text-sm transition">
            Go to dashboard
        </a>
    </div>
@endsection
