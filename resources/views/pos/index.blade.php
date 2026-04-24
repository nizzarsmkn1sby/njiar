<x-app-layout>
    <div x-data="posSystem()" class="h-full flex overflow-hidden -mx-6 -my-6">
        <!-- Products Section -->
        <div class="flex-1 flex flex-col p-8 overflow-y-auto">
            <div class="mb-10 flex justify-between items-end">
                <div>
                    <h2 class="font-black text-5xl tracking-tighter uppercase leading-none">Terminal</h2>
                    <p class="text-[10px] font-bold text-white/20 uppercase tracking-[0.3em] mt-3">Advanced POS System v2.0</p>
                </div>
                <div class="flex gap-4 items-end">
                    <div class="relative w-80 group">
                        <i data-lucide="search" class="absolute left-5 top-1/2 -translate-y-1/2 w-4 h-4 text-white/20 group-focus-within:text-white transition-colors"></i>
                        <input type="text" x-model="search" placeholder="Quick search..." class="w-full bg-white/5 border border-white/5 rounded-2xl py-4 pl-14 pr-6 text-sm focus:border-white/20 focus:bg-white/[0.08] focus:ring-0 transition-all text-white placeholder:text-white/20">
                    </div>
                </div>
            </div>

            <!-- Categories -->
            <div class="mb-12 flex flex-wrap gap-2">
                <button @click="selectedCategory = 'all'" 
                    :class="selectedCategory === 'all' ? 'bg-white text-black shadow-[0_10px_20px_rgba(255,255,255,0.1)]' : 'bg-white/5 text-white/40 hover:bg-white/10 hover:text-white'" 
                    class="px-8 py-4 text-[10px] font-black rounded-2xl uppercase tracking-[0.2em] transition-all active:scale-95">
                    All Items
                </button>
                <template x-for="cat in categories" :key="cat.id">
                    <button @click="selectedCategory = cat.id" 
                        :class="selectedCategory === cat.id ? 'bg-white text-black shadow-[0_10px_20px_rgba(255,255,255,0.1)]' : 'bg-white/5 text-white/40 hover:bg-white/10 hover:text-white'" 
                        class="px-8 py-4 text-[10px] font-black rounded-2xl uppercase tracking-[0.2em] transition-all active:scale-95" 
                        x-text="cat.name">
                    </button>
                </template>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                <template x-for="product in filteredProducts" :key="product.id">
                    <button @click="addToCart(product)" class="text-left group animate-in fade-in slide-in-from-bottom-4 duration-500">
                        <div class="aspect-square rounded-[32px] bg-white/5 border border-white/5 overflow-hidden mb-4 group-hover:border-white/20 transition-all relative">
                            <template x-if="product.image">
                                <img :src="'/storage/' + product.image" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            </template>
                            <template x-if="!product.image">
                                <div class="w-full h-full flex items-center justify-center">
                                    <i data-lucide="package" class="w-10 h-10 text-white/10 group-hover:scale-110 transition-transform duration-700"></i>
                                </div>
                            </template>
                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                <i data-lucide="plus-circle" class="w-10 h-10 text-white"></i>
                            </div>
                        </div>
                        <h4 class="font-bold text-sm tracking-tight text-white" x-text="product.name"></h4>
                        <div class="flex justify-between items-center mt-1">
                            <p class="text-[10px] text-white/40 uppercase font-bold tracking-widest" x-text="product.category.name"></p>
                            <p class="font-black text-sm text-white" x-text="formatPrice(product.price)"></p>
                        </div>
                    </button>
                </template>
            </div>
        </div>

        <!-- Cart Section -->
        <div class="w-[480px] bg-white/[0.02] border-l border-white/5 flex flex-col p-10 backdrop-blur-3xl relative">
            <div class="flex justify-between items-center mb-12">
                <div>
                    <h3 class="font-black text-3xl tracking-tighter uppercase text-white">Selection</h3>
                    <p class="text-[10px] font-bold text-white/20 uppercase tracking-widest mt-1">Pending order</p>
                </div>
                <button @click="clearCart()" class="w-12 h-12 rounded-2xl bg-white/5 border border-white/5 text-white/20 hover:text-red-400 hover:bg-red-500/10 hover:border-red-500/20 transition-all flex items-center justify-center">
                    <i data-lucide="trash-2" class="w-5 h-5"></i>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto space-y-6 pr-2">
                <template x-for="item in cart" :key="item.id">
                    <div class="flex justify-between items-center group">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 rounded-2xl bg-white/10 flex items-center justify-center font-black text-sm text-white" x-text="item.qty + 'x'"></div>
                            <div>
                                <p class="font-bold text-sm text-white" x-text="item.name"></p>
                                <p class="text-[10px] text-white/40 font-bold uppercase tracking-widest" x-text="formatPrice(item.price)"></p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-black text-sm text-white" x-text="formatPrice(item.price * item.qty)"></p>
                            <div class="flex gap-2 mt-2">
                                <button @click="updateQty(item.id, -1)" class="w-6 h-6 rounded-lg bg-white/5 border border-white/5 flex items-center justify-center text-xs text-white">-</button>
                                <button @click="updateQty(item.id, 1)" class="w-6 h-6 rounded-lg bg-white/5 border border-white/5 flex items-center justify-center text-xs text-white">+</button>
                            </div>
                        </div>
                    </div>
                </template>
                <template x-if="cart.length === 0">
                    <div class="h-full flex flex-col items-center justify-center opacity-20 py-20">
                        <i data-lucide="shopping-cart" class="w-12 h-12 mb-4"></i>
                        <p class="text-[10px] font-bold uppercase tracking-widest text-white">Cart is empty</p>
                    </div>
                </template>
            </div>

            <div class="mt-8 pt-8 border-t border-white/5 space-y-4">
                <div class="flex flex-col gap-4 mb-6">
                    <label class="text-[10px] font-bold text-white/40 uppercase tracking-widest">Payment Amount</label>
                    <input type="number" x-model="payAmount" class="w-full bg-white/10 border-none rounded-2xl py-4 px-6 text-2xl font-black text-white focus:ring-2 focus:ring-white/20 transition-all" placeholder="0">
                </div>

                <div class="flex justify-between items-center opacity-40 text-[10px] font-bold uppercase tracking-widest text-white">
                    <span>Subtotal</span>
                    <span x-text="formatPrice(subtotal)"></span>
                </div>
                <div class="flex justify-between items-center opacity-40 text-[10px] font-bold uppercase tracking-widest text-white">
                    <span>Tax (10%)</span>
                    <span x-text="formatPrice(tax)"></span>
                </div>
                <div class="flex justify-between items-center pt-2">
                    <span class="font-black text-xl tracking-tighter uppercase text-white">Total</span>
                    <span class="font-black text-3xl tracking-tighter text-white" x-text="formatPrice(total)"></span>
                </div>
                
                <div x-show="changeAmount >= 0 && payAmount > 0" class="flex justify-between items-center py-4 px-6 bg-emerald-500/10 border border-emerald-500/20 rounded-2xl animate-in fade-in zoom-in duration-300">
                    <span class="text-[10px] font-bold uppercase tracking-widest text-emerald-400">Change</span>
                    <span class="font-black text-xl text-emerald-400" x-text="formatPrice(changeAmount)"></span>
                </div>

                <button 
                    @click="checkout()" 
                    :disabled="cart.length === 0 || payAmount < total"
                    :class="cart.length === 0 || payAmount < total ? 'opacity-20 cursor-not-allowed' : 'hover:bg-white/90 active:scale-95'"
                    class="w-full py-6 bg-white text-black font-black rounded-[2rem] transition-all uppercase tracking-[0.2em] text-sm mt-8 shadow-[0_20px_40px_rgba(255,255,255,0.1)]">
                    Process Transaction
                </button>
            </div>
        </div>

        <!-- Success Modal -->
        <div x-show="showSuccess" class="fixed inset-0 z-[100] flex items-center justify-center p-6 bg-black/80 backdrop-blur-md animate-in fade-in duration-500">
            <div class="bg-white text-black p-12 rounded-[60px] max-w-sm w-full text-center space-y-8 animate-in zoom-in-95 duration-300">
                <div class="w-20 h-20 bg-black rounded-3xl flex items-center justify-center mx-auto">
                    <i data-lucide="check" class="w-10 h-10 text-white"></i>
                </div>
                <div>
                    <h3 class="text-3xl font-black tracking-tighter uppercase">Success!</h3>
                    <p class="text-sm opacity-60">Transaction has been processed.</p>
                </div>
                <div class="space-y-4 pt-4 border-t border-black/5">
                    <button @click="printReceipt()" class="w-full py-4 bg-emerald-500 text-white font-bold rounded-2xl uppercase tracking-widest text-xs flex items-center justify-center gap-2">
                        <i data-lucide="printer" class="w-4 h-4"></i>
                        Print Receipt
                    </button>
                    <button @click="resetPOS()" class="w-full py-4 bg-black text-white font-bold rounded-2xl uppercase tracking-widest text-xs">New Transaction</button>
                    <button @click="resetPOS()" class="w-full py-4 border border-black/10 font-bold rounded-2xl uppercase tracking-widest text-xs">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function posSystem() {
            return {
                products: @json($products),
                categories: @json($categories),
                search: '',
                selectedCategory: 'all',
                cart: [],
                payAmount: 0,
                showSuccess: false,
                lastTransactionId: null,
                
                get filteredProducts() {
                    return this.products.filter(p => {
                        const matchSearch = p.name.toLowerCase().includes(this.search.toLowerCase());
                        const matchCategory = this.selectedCategory === 'all' || p.category_id === this.selectedCategory;
                        return matchSearch && matchCategory;
                    });
                },
                
                get subtotal() {
                    return this.cart.reduce((sum, item) => sum + (item.price * item.qty), 0);
                },
                
                get tax() {
                    return this.subtotal * 0.1;
                },
                
                get total() {
                    return this.subtotal + this.tax;
                },
                
                get changeAmount() {
                    return this.payAmount - this.total;
                },
                
                addToCart(product) {
                    const item = this.cart.find(i => i.id === product.id);
                    if (item) {
                        item.qty++;
                    } else {
                        this.cart.push({
                            id: product.id,
                            name: product.name,
                            price: product.price,
                            qty: 1
                        });
                    }
                    setTimeout(() => lucide.createIcons(), 10);
                },
                
                updateQty(id, delta) {
                    const item = this.cart.find(i => i.id === id);
                    if (item) {
                        item.qty += delta;
                        if (item.qty <= 0) {
                            this.cart = this.cart.filter(i => i.id !== id);
                        }
                    }
                    setTimeout(() => lucide.createIcons(), 10);
                },
                
                clearCart() {
                    this.cart = [];
                },
                
                formatPrice(price) {
                    return 'Rp ' + new Intl.NumberFormat('id-ID').format(price);
                },
                
                async checkout() {
                    try {
                        const response = await fetch('{{ route('pos.checkout') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                cart: this.cart,
                                pay: this.payAmount
                            })
                        });
                        
                        let data;
                        try {
                            data = await response.json();
                        } catch (e) {
                            alert('Server Error: Transaction could not be processed.');
                            return;
                        }

                        if (response.ok) {
                            this.lastTransactionId = data.transaction_id;
                            this.showSuccess = true;
                            this.printReceipt();
                            this.cart = []; // Clear cart immediately
                            this.payAmount = 0; // Clear pay amount
                            setTimeout(() => lucide.createIcons(), 10);
                        } else {
                            alert(data.message || 'Transaction failed');
                        }
                    } catch (e) {
                        alert('Something went wrong');
                    }
                },
                
                resetPOS() {
                    this.cart = [];
                    this.payAmount = 0;
                    this.showSuccess = false;
                    this.lastTransactionId = null;
                },

                printReceipt() {
                    if (this.lastTransactionId) {
                        window.open(`/transactions/${this.lastTransactionId}/receipt`, '_blank', 'width=400,height=600');
                    }
                }
            }
        }
    </script>
</x-app-layout>
