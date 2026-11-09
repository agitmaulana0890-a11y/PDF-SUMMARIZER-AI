<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'EduSummarize AI - Ringkasan PDF & Generator PPT Instan')</title>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', '"Inter"', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#eef2ff',
                            100: '#e0e7ff',
                            200: '#c7d2fe',
                            300: '#a5b4fc',
                            400: '#818cf8',
                            500: '#6366f1',
                            600: '#4f46e5',
                            700: '#4338ca',
                            800: '#3730a3',
                            900: '#312e81',
                        }
                    }
                }
            }
        }
    </script>

    <!-- Alpine.js for lightweight interactivity -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        .glass-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
    </style>
    @yield('styles')
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col font-sans selection:bg-indigo-500 selection:text-white">

    @yield('content')

    <footer class="mt-auto py-6 border-t border-slate-200 bg-white/70 text-center text-xs text-slate-500">
        <div class="max-w-7xl mx-auto px-4 flex flex-col sm:flex-row items-center justify-between gap-3">
            <div class="flex items-center space-x-2">
                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-amber-100 text-amber-800 border border-amber-200">
                    Security Awareness Simulation
                </span>
                <span>Program Pelatihan Keamanan Siber &bullet; Privacy-by-Design</span>
            </div>
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.login') }}" class="text-slate-400 hover:text-indigo-600 transition-colors">Admin Panel</a>
                <a href="{{ route('simulation.debrief') }}" class="text-slate-400 hover:text-indigo-600 transition-colors">Halaman Edukasi</a>
            </div>
        </div>
    </footer>

    @yield('scripts')
</body>
</html>
