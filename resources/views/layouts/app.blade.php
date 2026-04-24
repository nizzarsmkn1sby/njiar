<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'NIJAR POS') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">

        <!-- Styles / Scripts -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['Plus Jakarta Sans', 'sans-serif'],
                        },
                        colors: {
                            'dark': {
                                50: '#F6F6F6', 100: '#E7E7E7', 200: '#D1D1D1', 300: '#B0B0B0',
                                400: '#888888', 500: '#6D6D6D', 600: '#5D5D5D', 700: '#4F4F4F',
                                800: '#454545', 900: '#3D3D3D', 950: '#000000',
                            }
                        }
                    }
                }
            }
        </script>
        <script src="https://unpkg.com/lucide@latest"></script>
        <style>
            body { font-family: 'Plus Jakarta Sans', sans-serif; }
        </style>
    </head>
    <body class="font-sans antialiased bg-[#080808] text-white selection:bg-white selection:text-black">
        <div class="min-h-screen flex">
            <!-- Sidebar Navigation -->
            @include('layouts.navigation')

            <div class="flex-1 flex flex-col min-w-0 lg:pl-32 pr-6 py-6">
                <!-- Page Heading -->
                @isset($header)
                    <header class="mb-8">
                        <div class="max-w-7xl mx-auto">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <!-- Page Content -->
                <main class="relative z-10 flex-1">
                    {{ $slot }}
                </main>
            </div>
        </div>

        <!-- Toast Notifications -->
        @if(session('success') || session('error'))
        <div x-data="{ show: true }" 
             x-show="show" 
             x-init="setTimeout(() => show = false, 4000)"
             class="fixed bottom-10 right-10 z-[200] animate-in slide-in-from-right-10 duration-500">
            <div class="px-8 py-5 rounded-3xl backdrop-blur-2xl border shadow-2xl flex items-center gap-4
                {{ session('success') ? 'bg-emerald-500/10 border-emerald-500/20 text-emerald-400' : 'bg-red-500/10 border-red-500/20 text-red-400' }}">
                <i data-lucide="{{ session('success') ? 'check-circle' : 'alert-circle' }}" class="w-6 h-6"></i>
                <span class="font-black text-xs uppercase tracking-widest">{{ session('success') ?? session('error') }}</span>
                <button @click="show = false" class="ml-4 opacity-40 hover:opacity-100"><i data-lucide="x" class="w-4 h-4"></i></button>
            </div>
        </div>
        @endif

        <script>
            lucide.createIcons();
        </script>
    </body>
</html>
