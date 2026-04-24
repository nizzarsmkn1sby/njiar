<x-app-layout>
    <div x-data="reportSystem()">
        <div class="max-w-7xl mx-auto px-6 pt-6 pb-12">
            {{-- Header --}}
            <div class="flex justify-between items-center mb-12">
                <div>
                    <h2 class="font-black text-4xl tracking-tighter uppercase">Reports</h2>
                    <p class="text-[10px] font-bold text-white/20 uppercase tracking-[0.3em] mt-2">Sales Overview & History</p>
                </div>
                <div class="flex gap-4">
                    <a href="{{ route('transactions.export') }}" class="px-6 py-3 bg-white/5 border border-white/5 text-white/60 text-[10px] font-bold rounded-xl hover:text-white transition-all uppercase tracking-widest flex items-center gap-2">
                        <i data-lucide="file-spreadsheet" class="w-4 h-4"></i>
                        Export CSV
                    </a>
                </div>
            </div>

            {{-- Summary Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                <div class="bg-white/5 border border-white/5 rounded-[32px] p-8 flex items-center gap-6 group hover:bg-white/[0.07] transition-all">
                    <div class="w-16 h-16 rounded-2xl bg-emerald-500/10 flex items-center justify-center text-emerald-400 group-hover:scale-110 transition-transform">
                        <i data-lucide="banknote" class="w-8 h-8"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-white/20 uppercase tracking-[0.2em] mb-1">Total Revenue</p>
                        <h3 class="text-3xl font-black text-white" x-text="formatPrice(totalRevenue)"></h3>
                    </div>
                </div>
                <div class="bg-white/5 border border-white/5 rounded-[32px] p-8 flex items-center gap-6 group hover:bg-white/[0.07] transition-all">
                    <div class="w-16 h-16 rounded-2xl bg-blue-500/10 flex items-center justify-center text-blue-400 group-hover:scale-110 transition-transform">
                        <i data-lucide="shopping-cart" class="w-8 h-8"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-white/20 uppercase tracking-[0.2em] mb-1">Total Orders</p>
                        <h3 class="text-3xl font-black text-white" x-text="transactions.length"></h3>
                    </div>
                </div>
                <div class="bg-white/5 border border-white/5 rounded-[32px] p-8 flex items-center gap-6 group hover:bg-white/[0.07] transition-all">
                    <div class="w-16 h-16 rounded-2xl bg-purple-500/10 flex items-center justify-center text-purple-400 group-hover:scale-110 transition-transform">
                        <i data-lucide="package" class="w-8 h-8"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-white/20 uppercase tracking-[0.2em] mb-1">Items Sold</p>
                        <h3 class="text-3xl font-black text-white" x-text="totalItemsSold"></h3>
                    </div>
                </div>
            </div>

            {{-- Transactions Table --}}
            <div class="bg-white/5 border border-white/5 rounded-[40px] overflow-hidden shadow-2xl">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b border-white/5 text-[10px] font-bold uppercase tracking-[0.2em] text-white/40">

                            <th class="px-8 py-6">Date</th>
                            <th class="px-8 py-6">Cashier</th>
                            <th class="px-8 py-6">Total</th>
                            <th class="px-8 py-6 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        <template x-for="tr in transactions" :key="tr.id">
                            <tr class="group hover:bg-white/5 transition-colors">

                                <td class="px-8 py-6">
                                    <span class="text-xs text-white/40" x-text="formatDate(tr.transaction_date)"></span>
                                </td>
                                <td class="px-8 py-6">
                                    <span class="text-sm text-white/60" x-text="tr.user.name"></span>
                                </td>
                                <td class="px-8 py-6 font-black text-sm text-white" x-text="formatPrice(tr.total_price)"></td>
                                <td class="px-8 py-6 text-right">
                                    <button @click="showDetail(tr)" class="px-6 py-2 rounded-xl bg-white/5 border border-white/5 text-[10px] font-bold uppercase tracking-widest hover:bg-white text-white/40 hover:text-black transition-all">
                                        View Details
                                    </button>
                                </td>
                            </tr>
                        </template>
                        <template x-if="transactions.length === 0">
                            <tr>
                                <td colspan="5" class="px-8 py-20 text-center">
                                    <div class="flex flex-col items-center gap-4 opacity-20">
                                        <i data-lucide="history" class="w-12 h-12"></i>
                                        <p class="text-[10px] font-bold uppercase tracking-[0.2em]">No transactions recorded</p>
                                    </div>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Detail Modal --}}
        <div x-show="selectedTransaction" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-6 bg-black/80 backdrop-blur-md">
            <div @click.away="selectedTransaction = null" class="bg-[#111] border border-white/10 p-10 rounded-[40px] max-w-2xl w-full space-y-8 animate-in zoom-in-95 duration-300">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-[10px] font-bold text-white/20 uppercase tracking-[0.3em] mb-2">Transaction Detail</p>
                        <h3 class="text-3xl font-black tracking-tighter uppercase text-white">Transaction Success</h3>
                        <p class="text-xs text-white/40 mt-1" x-text="selectedTransaction ? formatDate(selectedTransaction.transaction_date) : ''"></p>
                    </div>
                    <button @click="printReceipt(selectedTransaction.id)" class="px-6 py-3 bg-emerald-500 text-white text-[10px] font-bold rounded-xl hover:bg-emerald-600 transition-all uppercase tracking-widest flex items-center gap-2">
                        <i data-lucide="printer" class="w-4 h-4"></i>
                        Print Receipt
                    </button>
                </div>

                <div class="bg-white/5 rounded-3xl overflow-hidden border border-white/5">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-white/5 text-[10px] font-bold uppercase tracking-widest text-white/40">
                                <th class="px-6 py-4">Item</th>
                                <th class="px-6 py-4 text-center">Qty</th>
                                <th class="px-6 py-4 text-right">Price</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            <template x-for="item in selectedTransaction?.details" :key="item.id">
                                <tr>
                                    <td class="px-6 py-4 text-sm font-bold text-white" x-text="item.product ? item.product.name : 'Deleted Product'"></td>
                                    <td class="px-6 py-4 text-center text-sm text-white/60" x-text="item.qty"></td>
                                    <td class="px-6 py-4 text-right text-sm font-black text-white" x-text="formatPrice(item.subtotal)"></td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>

                <div class="grid grid-cols-2 gap-8">
                    <div class="space-y-4">
                        <div class="p-6 bg-white/5 rounded-3xl space-y-2">
                            <p class="text-[10px] font-bold text-white/20 uppercase tracking-widest">Cashier</p>
                            <p class="font-bold text-white" x-text="selectedTransaction?.user.name"></p>
                        </div>
                    </div>
                    <div class="p-8 bg-white/5 rounded-[32px] space-y-4">
                        <div class="flex justify-between items-center text-[10px] font-bold text-white/40 uppercase tracking-widest">
                            <span>Subtotal</span>
                            <span x-text="formatPrice(selectedTransaction?.total_price * 0.9)"></span>
                        </div>
                        <div class="flex justify-between items-center text-[10px] font-bold text-white/40 uppercase tracking-widest">
                            <span>Tax (10%)</span>
                            <span x-text="formatPrice(selectedTransaction?.total_price * 0.1)"></span>
                        </div>
                        <div class="pt-4 border-t border-white/5 flex justify-between items-center">
                            <span class="text-sm font-black uppercase text-white">Total</span>
                            <span class="text-2xl font-black text-white" x-text="formatPrice(selectedTransaction?.total_price)"></span>
                        </div>
                        <div class="flex justify-between items-center text-xs">
                            <span class="text-white/40">Paid</span>
                            <span class="text-emerald-400 font-bold" x-text="formatPrice(selectedTransaction?.pay)"></span>
                        </div>
                        <div class="flex justify-between items-center text-xs">
                            <span class="text-white/40">Change</span>
                            <span class="text-white font-bold" x-text="formatPrice(selectedTransaction?.change)"></span>
                        </div>
                    </div>
                </div>

                <button @click="selectedTransaction = null" class="w-full py-4 border border-white/10 text-white/40 font-bold rounded-2xl uppercase text-[10px]">Close</button>
            </div>
        </div>
    </div>

    <script>
        function reportSystem() {
            return {
                transactions: @json($transactions),
                selectedTransaction: null,

                get totalRevenue() {
                    return this.transactions.reduce((sum, tr) => sum + parseFloat(tr.total_price), 0);
                },

                get totalItemsSold() {
                    return this.transactions.reduce((sum, tr) => {
                        return sum + tr.details.reduce((s, d) => s + d.qty, 0);
                    }, 0);
                },

                formatPrice(price) {
                    return 'Rp ' + new Intl.NumberFormat('id-ID').format(price);
                },

                formatDate(dateStr) {
                    const date = new Date(dateStr);
                    return date.toLocaleDateString('id-ID', {
                        day: 'numeric',
                        month: 'long',
                        year: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit'
                    });
                },

                showDetail(tr) {
                    this.selectedTransaction = tr;
                    this.$nextTick(() => lucide.createIcons());
                },

                printReceipt(id) {
                    window.open(`/transactions/${id}/receipt`, '_blank', 'width=400,height=600');
                },

                init() {
                    this.$nextTick(() => lucide.createIcons());
                }
            }
        }
    </script>
    <style>[x-cloak] { display: none !important; }</style>
</x-app-layout>
