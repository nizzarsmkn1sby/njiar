<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-4xl tracking-tighter uppercase">
                Dashboard
            </h2>
            <a href="{{ route('pos.index') }}" class="px-6 py-3 bg-white text-black text-[10px] font-bold rounded-xl hover:bg-white/90 transition-all uppercase tracking-widest flex items-center gap-2">
                <i data-lucide="plus" class="w-4 h-4"></i>
                New Transaction
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-6">
            <!-- Bento Grid Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Total Revenue -->
                <div class="md:col-span-2 bg-white/5 border border-white/5 p-10 rounded-[40px] flex flex-col justify-between relative overflow-hidden group">
                    <div class="absolute right-0 top-0 p-10 opacity-10 group-hover:opacity-20 transition-opacity">
                        <i data-lucide="bar-chart-3" class="w-32 h-32"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-white/40 uppercase tracking-[0.2em] mb-4">Total Revenue</p>
                        <h3 class="text-6xl font-black tracking-tighter text-white">
                            Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                        </h3>
                    </div>
                    <div class="mt-8 flex items-center gap-2 text-emerald-400">
                        <i data-lucide="trending-up" class="w-4 h-4"></i>
                        <span class="text-[10px] font-bold uppercase tracking-widest">Real-time data from database</span>
                    </div>
                </div>

                <!-- Total Orders -->
                <div class="bg-white p-10 rounded-[40px] flex flex-col justify-between relative overflow-hidden group">
                    <div class="absolute right-0 top-0 p-8 opacity-5 text-black">
                        <i data-lucide="shopping-bag" class="w-24 h-24"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-black/40 uppercase tracking-[0.2em] mb-4">Total Orders</p>
                        <h3 class="text-6xl font-black tracking-tighter text-black">
                            {{ number_format($totalOrders) }}
                        </h3>
                    </div>
                    <p class="mt-8 text-[10px] font-bold text-black/20 uppercase tracking-widest">Processed Transactions</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Side Stats -->
                <div class="space-y-6">
                    <div class="bg-white/5 border border-white/5 p-8 rounded-[40px] flex items-center justify-between group">
                        <div>
                            <p class="text-[10px] font-bold text-white/40 uppercase tracking-widest mb-1">Inventory Items</p>
                            <h4 class="text-3xl font-black text-white">{{ $totalProducts }}</h4>
                        </div>
                        <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center">
                            <i data-lucide="package" class="w-6 h-6 text-white/40"></i>
                        </div>
                    </div>
                    <div class="bg-white/5 border border-white/5 p-8 rounded-[40px] flex items-center justify-between group">
                        <div>
                            <p class="text-[10px] font-bold text-white/40 uppercase tracking-widest mb-1">Low Stock Alert</p>
                            <h4 class="text-3xl font-black {{ $lowStockProducts > 0 ? 'text-red-400' : 'text-white' }}">{{ $lowStockProducts }}</h4>
                        </div>
                        <div class="w-12 h-12 {{ $lowStockProducts > 0 ? 'bg-red-500/20' : 'bg-white/10' }} rounded-2xl flex items-center justify-center">
                            <i data-lucide="alert-triangle" class="w-6 h-6 {{ $lowStockProducts > 0 ? 'text-red-400' : 'text-white/40' }}"></i>
                        </div>
                    </div>
                </div>

                <!-- Recent Transactions -->
                <div class="md:col-span-2 bg-white/5 border border-white/5 rounded-[40px] overflow-hidden">
                    <div class="px-8 py-6 border-b border-white/5 flex justify-between items-center">
                        <h4 class="text-[10px] font-bold uppercase tracking-widest text-white/40">Recent Transactions</h4>
                        <a href="{{ route('transactions.index') }}" class="text-[10px] font-bold uppercase tracking-widest text-white/20 hover:text-white transition-colors">View All</a>
                    </div>
                    <div class="divide-y divide-white/5">
                        @forelse($recentTransactions as $tr)
                        <div class="px-8 py-6 flex items-center justify-between group hover:bg-white/5 transition-colors">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center">
                                    <i data-lucide="file-text" class="w-4 h-4 text-white/40"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-white">{{ $tr->invoice_number }}</p>
                                    <p class="text-[10px] text-white/20 font-bold uppercase">{{ $tr->user->name }} • {{ $tr->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-black text-white">Rp {{ number_format($tr->total_price, 0, ',', '.') }}</p>
                                <p class="text-[9px] font-bold text-emerald-400 uppercase tracking-widest">Success</p>
                            </div>
                        </div>
                        @empty
                        <div class="px-8 py-20 text-center opacity-20">
                            <p class="uppercase text-[10px] font-bold">No transactions yet</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
