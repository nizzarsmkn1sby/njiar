<nav x-data="{ open: false }" class="fixed left-6 top-6 bottom-6 w-20 hover:w-64 transition-all duration-500 ease-in-out group z-[100] hidden lg:flex flex-col bg-black/40 backdrop-blur-3xl border border-white/10 rounded-[2.5rem] py-8 overflow-hidden shadow-[0_0_50px_rgba(0,0,0,0.5)]">
    <!-- Brand/Logo -->
    <div class="px-6 mb-12 flex items-center gap-4">
        <div class="w-8 h-8 flex-shrink-0 bg-white rounded-xl flex items-center justify-center shadow-[0_0_20px_rgba(255,255,255,0.2)]">
            <i data-lucide="zap" class="text-black w-4 h-4 stroke-[3px]"></i>
        </div>
        <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-300">
            <span class="font-black text-lg tracking-tighter uppercase whitespace-nowrap">NIJAR<span class="text-white/40">PRO</span></span>
        </div>
    </div>

    <!-- Main Links -->
    <div class="flex-1 px-4 space-y-3">
        @php
            $links = [
                ['route' => 'dashboard', 'icon' => 'layout-grid', 'label' => 'Dashboard'],
                ['route' => 'inventory.index', 'icon' => 'package', 'label' => 'Inventory', 'role' => 'owner'],
                ['route' => 'pos.index', 'icon' => 'monitor-smartphone', 'label' => 'Cashier'],
                ['route' => 'transactions.index', 'icon' => 'bar-chart-3', 'label' => 'Report', 'role' => 'owner'],
            ];
        @endphp

        @foreach($links as $link)
            @if(!isset($link['role']) || Auth::user()->role === $link['role'])
                <a href="{{ route($link['route']) }}" 
                   class="flex items-center gap-4 p-3 rounded-2xl transition-all duration-300 relative group/item
                   {{ request()->routeIs($link['route']) ? 'bg-white text-black shadow-[0_0_30px_rgba(255,255,255,0.2)]' : 'text-white/40 hover:text-white hover:bg-white/5' }}">
                    <div class="w-6 h-6 flex items-center justify-center flex-shrink-0">
                        <i data-lucide="{{ $link['icon'] }}" class="w-5 h-5 {{ request()->routeIs($link['route']) ? 'stroke-[2.5px]' : 'stroke-[1.5px]' }}"></i>
                    </div>
                    <span class="opacity-0 group-hover:opacity-100 transition-opacity duration-300 font-bold text-[10px] uppercase tracking-[0.2em] whitespace-nowrap">
                        {{ $link['label'] }}
                    </span>
                    
                    @if(request()->routeIs($link['route']))
                        <div class="absolute left-0 w-1 h-6 bg-white rounded-full -translate-x-4 opacity-0 group-hover:opacity-100 transition-all"></div>
                    @endif
                </a>
            @endif
        @endforeach
    </div>

    <!-- Footer Links -->
    <div class="px-4 space-y-3 pt-6 border-t border-white/5">
        <a href="{{ route('profile.edit') }}" 
           class="flex items-center gap-4 p-3 rounded-2xl text-white/40 hover:text-white hover:bg-white/5 transition-all duration-300 group/item">
            <div class="w-6 h-6 flex items-center justify-center flex-shrink-0">
                <i data-lucide="user" class="w-5 h-5 stroke-[1.5px]"></i>
            </div>
            <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-300 overflow-hidden">
                <div class="font-bold text-[10px] uppercase tracking-[0.2em] whitespace-nowrap">{{ Auth::user()->name }}</div>
                <div class="text-[8px] text-white/20 uppercase tracking-widest whitespace-nowrap">Settings</div>
            </div>
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center gap-4 p-3 rounded-2xl text-red-400/60 hover:text-red-400 hover:bg-red-500/10 transition-all duration-300 group/item">
                <div class="w-6 h-6 flex items-center justify-center flex-shrink-0">
                    <i data-lucide="log-out" class="w-5 h-5 stroke-[1.5px]"></i>
                </div>
                <span class="opacity-0 group-hover:opacity-100 transition-opacity duration-300 font-bold text-[10px] uppercase tracking-[0.2em] whitespace-nowrap">
                    Disconnect
                </span>
            </button>
        </form>
    </div>
</nav>

<!-- Mobile Navigation (Bottom Bar) -->
<div class="lg:hidden fixed bottom-6 left-6 right-6 h-16 bg-black/60 backdrop-blur-2xl border border-white/10 rounded-2xl z-[100] flex items-center justify-around px-4">
    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'text-white' : 'text-white/40' }}">
        <i data-lucide="layout-grid" class="w-6 h-6"></i>
    </a>
    @if(Auth::user()->role === 'owner')
    <a href="{{ route('inventory.index') }}" class="{{ request()->routeIs('inventory.*') ? 'text-white' : 'text-white/40' }}">
        <i data-lucide="package" class="w-6 h-6"></i>
    </a>
    @endif
    <a href="{{ route('pos.index') }}" class="{{ request()->routeIs('pos.*') ? 'text-white' : 'text-white/40' }}">
        <i data-lucide="monitor-smartphone" class="w-6 h-6"></i>
    </a>
    <button @click="open = !open" class="text-white/40">
        <i data-lucide="more-horizontal" class="w-6 h-6"></i>
    </button>
</div>
