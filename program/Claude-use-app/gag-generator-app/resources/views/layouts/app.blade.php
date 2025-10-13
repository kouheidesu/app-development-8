<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title ?? 'Memórie Notes' }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-slate-100 min-h-screen antialiased">
        <div class="relative">
            @if (session('status'))
                <div class="fixed inset-x-0 top-0 z-50 flex justify-center px-4 pt-6">
                    <div class="max-w-xl w-full rounded-2xl bg-white/90 shadow-xl border border-slate-200 backdrop-blur">
                        <div class="flex items-center gap-3 px-5 py-4">
                            <div class="shrink-0 h-10 w-10 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center">
                                <span class="text-lg">✨</span>
                            </div>
                            <p class="text-sm font-medium text-slate-700">{{ session('status') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <main class="px-4 pb-16 pt-16 sm:pt-24">
                {{ $slot ?? '' }}
                @yield('content')
            </main>
        </div>
        @stack('scripts')
    </body>
</html>
