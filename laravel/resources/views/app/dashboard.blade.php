@extends('layouts.auth')

@section('title', 'Dashboard — Seav.ai')

@section('content')
    <div class="text-center py-4">
        <h1 class="text-2xl font-bold text-slate-900 mb-1">Welcome, {{ auth()->user()->name }}</h1>
        <p class="text-slate-500 text-sm">Your dashboard is coming soon.</p>
        <form method="POST" action="{{ route('logout') }}" class="mt-6">
            @csrf
            <button type="submit" class="text-sm text-blue-600 hover:underline">Sign out</button>
        </form>
    </div>
@endsection
