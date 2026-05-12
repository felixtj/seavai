@extends('layouts.auth')

@section('title', 'Verify your email — Seav.ai')

@section('content')
    <div class="text-center">
        <div class="w-14 h-14 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-7 h-7 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
        </div>
        <h1 class="text-xl font-bold text-slate-900 mb-2">Check your inbox</h1>
        <p class="text-slate-500 text-sm mb-6">
            We've sent a verification link to <strong>{{ auth()->user()->email }}</strong>.
            Click the link to activate your account.
        </p>

        @if (session('status') === 'verification-link-sent')
            <div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm">
                A new verification link has been sent.
            </div>
        @endif

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit"
                    class="text-blue-600 text-sm font-medium hover:underline">
                Resend verification email
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}" class="mt-4">
            @csrf
            <button type="submit" class="text-slate-400 text-sm hover:text-slate-600">
                Sign out
            </button>
        </form>
    </div>
@endsection
