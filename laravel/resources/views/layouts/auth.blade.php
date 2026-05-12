<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Seav.ai')</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="min-h-screen bg-slate-100 flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2">
                <div class="w-9 h-9 bg-blue-600 rounded-lg flex items-center justify-center text-white font-bold text-sm">S</div>
                <span class="text-xl font-bold text-slate-900">seav<span class="text-blue-600">.ai</span></span>
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8">
            @yield('content')
        </div>

        <p class="text-center text-xs text-slate-400 mt-6">
            By continuing you agree to our
            <a href="{{ route('privacy') }}" class="underline hover:text-slate-600">Privacy Policy</a>.
        </p>
    </div>
</body>
</html>
