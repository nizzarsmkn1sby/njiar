<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'NIJAR POS') }}</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
        <script src="https://cdn.tailwindcss.com"></script>
        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['Plus Jakarta Sans', 'sans-serif'],
                        }
                    }
                }
            }
        </script>
        <script src="https://unpkg.com/lucide@latest"></script>
        <style>
            body { font-family: 'Plus Jakarta Sans', sans-serif; }
            .glass {
                background: rgba(255, 255, 255, 0.03);
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.05);
            }
            @keyframes float {
                0% { transform: translateY(0px) rotate(0deg); }
                50% { transform: translateY(-20px) rotate(5deg); }
                100% { transform: translateY(0px) rotate(0deg); }
            }
            .animate-float { animation: float 6s ease-in-out infinite; }
            .animate-float-delayed { animation: float 8s ease-in-out infinite; animation-delay: 2s; }
            .blob {
                position: absolute;
                width: 500px;
                height: 500px;
                background: linear-gradient(180deg, rgba(255,255,255,0.05) 0%, rgba(255,255,255,0) 100%);
                filter: blur(80px);
                border-radius: 50%;
                z-index: -1;
            }
        </style>
    </head>
    <body class="antialiased bg-[#000] text-white selection:bg-white selection:text-black overflow-x-hidden">
        <div class="blob top-[-200px] left-[-200px] animate-pulse"></div>
        <div class="blob bottom-[-200px] right-[-200px] animate-pulse" style="animation-delay: 3s"></div>

        <nav class="fixed top-0 w-full z-50 border-b border-white/5 bg-black/50 backdrop-blur-md">
            <div class="max-w-7xl mx-auto px-6 h-20 flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center">
                        <i data-lucide="scan-line" class="text-black w-6 h-6"></i>
                    </div>
                    <span class="font-bold text-xl tracking-tighter uppercase">NIJAR<span class="text-white/40">POS</span></span>
                </div>
                <div class="flex items-center gap-8">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-sm font-medium hover:text-white/60 transition-colors uppercase tracking-widest">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-medium hover:text-white/60 transition-colors uppercase tracking-widest">Login</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-6 py-2 bg-white text-black text-sm font-bold rounded-full hover:bg-white/90 transition-all uppercase tracking-widest">Register</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </nav>

        <main class="relative pt-32 pb-20 min-h-screen flex items-center">
            <div class="max-w-7xl mx-auto px-6 grid lg:grid-cols-2 gap-20 items-center">
                <div class="space-y-10">
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-white/10 bg-white/5 text-xs font-bold uppercase tracking-widest text-white/60">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-white"></span>
                        </span>
                        Next-Gen Cashier System
                    </div>
                    <h1 class="text-7xl lg:text-8xl font-black tracking-tighter leading-[0.9]">
                        CALM.<br/>
                        <span class="text-transparent bg-clip-text bg-gradient-to-b from-white to-white/20">AESTHETIC.</span><br/>
                        POS.
                    </h1>
                    <p class="text-lg text-white/40 max-w-md leading-relaxed">
                        Ubah cara Anda mengelola bisnis dengan sistem kasir yang tenang, minimalis, namun sangat bertenaga. Fokus pada POS bukan minimarket.
                    </p>
                    <div class="flex items-center gap-6">
                        <a href="{{ route('login') }}" class="px-10 py-5 bg-white text-black font-black rounded-2xl hover:scale-105 transition-transform uppercase tracking-tighter text-xl">
                            Mulai Sekarang
                        </a>
                        <div class="flex -space-x-4">
                            @for ($i = 1; $i <= 4; $i++)
                                <div class="w-12 h-12 rounded-full border-4 border-black bg-white/10 flex items-center justify-center text-[10px] font-bold">U{{$i}}</div>
                            @endfor
                            <div class="w-12 h-12 rounded-full border-4 border-black bg-white text-black flex items-center justify-center text-xs font-bold">+99</div>
                        </div>
                    </div>
                </div>

                <div class="relative">
                    <div class="glass p-8 rounded-[40px] border-white/10 animate-float">
                        <div class="flex justify-between items-start mb-10">
                            <div>
                                <p class="text-xs font-bold text-white/40 uppercase mb-1">Total Sales</p>
                                <h3 class="text-4xl font-black tracking-tighter">Rp 42.080.000</h3>
                            </div>
                            <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center">
                                <i data-lucide="trending-up" class="w-6 h-6 text-white"></i>
                            </div>
                        </div>
                        <div class="space-y-4">
                            @foreach(['Coffee Latte', 'Croissant', 'Espresso'] as $item)
                            <div class="flex justify-between items-center p-4 rounded-2xl bg-white/5 border border-white/5">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center">
                                        <i data-lucide="package" class="text-black w-5 h-5"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold">{{$item}}</p>
                                        <p class="text-[10px] text-white/40">Sold 12 today</p>
                                    </div>
                                </div>
                                <p class="text-sm font-black">+Rp 24k</p>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="absolute -bottom-10 -left-10 glass p-6 rounded-3xl border-white/10 animate-float-delayed">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-white text-black flex items-center justify-center">
                                <i data-lucide="shopping-cart" class="w-6 h-6"></i>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-white/40 uppercase">Inventory</p>
                                <p class="text-xl font-black">840 Items</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <footer class="border-t border-white/5 py-10">
            <div class="max-w-7xl mx-auto px-6 flex justify-between items-center opacity-40 text-[10px] font-bold uppercase tracking-[0.2em]">
                <p>&copy; 2026 NIJAR POS SYSTEM</p>
                <div class="flex gap-10">
                    <a href="#">Privacy</a>
                    <a href="#">Terms</a>
                    <a href="#">Support</a>
                </div>
            </div>
        </footer>

        <script>
            lucide.createIcons();
        </script>
    </body>
</html>
