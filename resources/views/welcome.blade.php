<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Aussie Auto Parts Inventory</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased bg-gray-50 text-gray-900 font-sans">
        
        <nav class="bg-white shadow-sm py-4 px-6 border-b border-gray-100">
            <div class="max-w-7xl mx-auto flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <x-application-logo />
                </div>

                <div class="space-x-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-700 hover:text-blue-600 transition">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="font-semibold text-gray-700 hover:text-blue-600 transition">Log in</a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-700 hover:text-blue-600 transition">Register</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </nav>

        <main class="max-w-7xl mx-auto px-6 py-20 md:py-32 flex flex-col items-center text-center">
            <span class="bg-blue-50 text-blue-700 text-xs font-bold uppercase tracking-widest px-4 py-1.5 rounded-full mb-4 border border-blue-200">
                Built for Australian Mechanical Workshops
            </span>
            
            <h1 class="text-4xl md:text-6xl font-extrabold text-gray-900 tracking-tight max-w-3xl leading-tight">
                Smart Vehicle Fitment & <br>
                <span class="text-blue-600">Auto Parts Inventory</span>
            </h1>
            
            <p class="mt-6 text-lg text-gray-600 max-w-2xl leading-relaxed">
                Streamline your garage logbook. Quickly track customer vehicles, manage physical stock numbers, check local Ryco equivalents, and log exact parts installation timestamps safely.
            </p>

            <div class="mt-10">
                @auth
                    <a href="{{ url('/dashboard') }}" class="inline-flex items-center justify-center px-8 py-4 bg-blue-600 hover:bg-blue-700 text-white font-bold text-lg rounded-xl shadow-lg hover:shadow-xl transition duration-150 transform hover:-translate-y-0.5">
                        Enter Workshop Dashboard
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-8 py-4 bg-blue-600 hover:bg-blue-700 text-white font-bold text-lg rounded-xl shadow-lg hover:shadow-xl transition duration-150 transform hover:-translate-y-0.5">
                        Log In to Start Tracking
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                    </a>
                @endauth
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-24 w-full text-left">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4 text-blue-600 font-bold text-lg">🔧</div>
                    <h3 class="text-lg font-bold text-gray-900">Local AU Catalog</h3>
                    <p class="mt-2 text-sm text-gray-600">Auto-populates known Ryco parts for common Aussie models like the Hilux, Commodore, Ranger, and Aurion.</p>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-4 text-green-600 font-bold text-lg">📦</div>
                    <h3 class="text-lg font-bold text-gray-900">Live Inventory</h3>
                    <p class="mt-2 text-sm text-gray-600">Manage stock quantities, adjust retail pricing models, and flag part configurations that require manual fitment verification.</p>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center mb-4 text-amber-600 font-bold text-lg">📅</div>
                    <h3 class="text-lg font-bold text-gray-900">Warranty Logging</h3>
                    <p class="mt-2 text-sm text-gray-600">Assign precise installation dates using permanent timestamps to maintain reliable warranty and service history records.</p>
                </div>
            </div>
        </main>

        <footer class="border-t border-gray-200 bg-white py-6 text-center text-xs text-gray-500 w-full mt-auto">
            &copy; {{ date('Y') }} WorkshopPro AU Inventory Management. Running locally.
        </footer>
    </body>
</html>