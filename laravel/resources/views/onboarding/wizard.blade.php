<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Get started — Seav.ai</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/htmx.org@2.0.4" defer></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="min-h-screen bg-slate-100 flex items-center justify-center p-4"
      x-data="{ step: {{ $step }} }">

    <script>
        document.body.addEventListener('htmx:configRequest', e => {
            e.detail.headers['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').content;
        });
    </script>

    <div class="w-full max-w-lg">
        {{-- Logo --}}
        <div class="text-center mb-6">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2">
                <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center text-white font-bold text-sm">S</div>
                <span class="text-lg font-bold text-slate-900">seav<span class="text-blue-600">.ai</span></span>
            </a>
        </div>

        {{-- Progress bar --}}
        <div class="mb-6">
            <div class="flex justify-between text-xs text-slate-400 mb-2">
                <span>Step <span x-text="step"></span> of 5</span>
                <span x-text="Math.round((step / 5) * 100) + '%'"></span>
            </div>
            <div class="h-1.5 bg-slate-200 rounded-full overflow-hidden">
                <div class="h-full bg-blue-600 rounded-full transition-all duration-300"
                     :style="'width: ' + (step / 5 * 100) + '%'"></div>
            </div>
        </div>

        {{-- Card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8">
            <div id="onboarding-body">
                @include('onboarding.partials.step', ['profile' => $profile, 'step' => $step])
            </div>
        </div>

        <p class="text-center text-xs text-slate-400 mt-4">
            You can update these anytime from Settings.
        </p>
    </div>
</body>
</html>
