<x-app-layout>
    <div x-data="inventorySystem()">
        {{-- Page Header --}}
        <div class="max-w-7xl mx-auto px-6 pt-6">
            <div class="flex justify-between items-center mb-12">
                <h2 class="font-black text-4xl tracking-tighter uppercase">Inventory</h2>
                <div class="flex gap-4">
                    <button @click="showManageCategories = true" class="px-6 py-3 bg-white/5 border border-white/5 text-white/60 text-[10px] font-bold rounded-xl hover:text-white transition-all uppercase tracking-widest flex items-center gap-2">
                        <i data-lucide="tag" class="w-4 h-4"></i>
                        Categories
                    </button>
                    <button @click="showAddProduct = true" class="px-6 py-3 bg-white text-black text-[10px] font-bold rounded-xl hover:bg-white/90 transition-all uppercase tracking-widest flex items-center gap-2">
                        <i data-lucide="plus" class="w-4 h-4"></i>
                        New Product
                    </button>
                </div>
            </div>

            {{-- Summary Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                <div class="bg-white/5 border border-white/5 rounded-[32px] p-8 flex items-center gap-6 group hover:bg-white/[0.07] transition-all">
                    <div class="w-16 h-16 rounded-2xl bg-blue-500/10 flex items-center justify-center text-blue-400 group-hover:scale-110 transition-transform">
                        <i data-lucide="package" class="w-8 h-8"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-white/20 uppercase tracking-[0.2em] mb-1">Total Products</p>
                        <h3 class="text-3xl font-black text-white" x-text="products.length"></h3>
                    </div>
                </div>
                <div class="bg-white/5 border border-white/5 rounded-[32px] p-8 flex items-center gap-6 group hover:bg-white/[0.07] transition-all">
                    <div class="w-16 h-16 rounded-2xl bg-amber-500/10 flex items-center justify-center text-amber-400 group-hover:scale-110 transition-transform">
                        <i data-lucide="alert-circle" class="w-8 h-8"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-white/20 uppercase tracking-[0.2em] mb-1">Low Stock</p>
                        <h3 class="text-3xl font-black text-white" x-text="products.filter(p => p.stock < 10).length"></h3>
                    </div>
                </div>
                <div class="bg-white/5 border border-white/5 rounded-[32px] p-8 flex items-center gap-6 group hover:bg-white/[0.07] transition-all">
                    <div class="w-16 h-16 rounded-2xl bg-emerald-500/10 flex items-center justify-center text-emerald-400 group-hover:scale-110 transition-transform">
                        <i data-lucide="tag" class="w-8 h-8"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-white/20 uppercase tracking-[0.2em] mb-1">Categories</p>
                        <h3 class="text-3xl font-black text-white" x-text="categories.length"></h3>
                    </div>
                </div>
            </div>

            {{-- Filter / Search --}}
            <div class="mb-8 flex flex-col md:flex-row gap-6 items-center justify-between">
                <div class="relative w-full md:w-96">
                    <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-white/40"></i>
                    <input type="text" x-model="search" placeholder="Search products..." class="w-full bg-white/5 border border-white/5 rounded-2xl py-4 pl-12 pr-6 text-sm focus:border-white/20 focus:ring-0 transition-all text-white">
                </div>
                <div class="flex flex-wrap gap-2 w-full md:w-auto">
                    <button @click="selectedCategory = 'all'" :class="selectedCategory === 'all' ? 'bg-white text-black' : 'bg-white/5 text-white/40'" class="px-6 py-3 text-[10px] font-bold rounded-xl uppercase tracking-widest transition-all">All Items</button>
                    <template x-for="cat in categories" :key="cat.id">
                        <button @click="selectedCategory = cat.id" :class="selectedCategory === cat.id ? 'bg-white text-black' : 'bg-white/5 text-white/40'" class="px-6 py-3 text-[10px] font-bold rounded-xl uppercase tracking-widest hover:text-white transition-all" x-text="cat.name"></button>
                    </template>
                </div>
            </div>

            {{-- Product Table --}}
            <div class="bg-white/5 border border-white/5 rounded-[40px] overflow-hidden shadow-2xl">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b border-white/5 text-[10px] font-bold uppercase tracking-[0.2em] text-white/40">
                            <th class="px-8 py-6">Product</th>
                            <th class="px-8 py-6">Category</th>
                            <th class="px-8 py-6">Price</th>
                            <th class="px-8 py-6">Stock</th>
                            <th class="px-8 py-6 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        <template x-for="product in filteredProducts" :key="product.id">
                            <tr class="group hover:bg-white/5 transition-colors">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 rounded-2xl bg-white/10 flex items-center justify-center overflow-hidden">
                                            <template x-if="product.image">
                                                <img :src="'/storage/' + product.image" class="w-full h-full object-cover">
                                            </template>
                                            <template x-if="!product.image">
                                                <i data-lucide="package" class="w-6 h-6 text-white/20"></i>
                                            </template>
                                        </div>
                                        <span class="font-bold text-sm text-white" x-text="product.name"></span>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <span class="px-3 py-1 bg-white/5 border border-white/5 rounded-full text-[10px] font-bold uppercase tracking-widest text-white/40" x-text="product.category ? product.category.name : '-'"></span>
                                </td>
                                <td class="px-8 py-6 font-black text-sm text-white" x-text="'Rp ' + new Intl.NumberFormat('id-ID').format(product.price)"></td>
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-2">
                                        <span class="font-bold text-white" :class="product.stock < 10 ? 'text-red-400' : ''" x-text="product.stock"></span>
                                        <span class="text-[10px] text-white/20 uppercase font-bold tracking-widest">Units</span>
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <div class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <button @click="selectedProduct = product.id; showRestock = true" class="px-4 py-2 rounded-xl bg-white/5 border border-white/5 text-[10px] font-bold uppercase tracking-widest hover:bg-white/10 transition-all flex items-center gap-2">
                                            <i data-lucide="refresh-cw" class="w-3 h-3"></i>
                                            Restock
                                        </button>
                                        <button @click="editProduct(product)" class="w-10 h-10 rounded-xl bg-white/5 border border-white/5 flex items-center justify-center hover:bg-white/10 transition-all">
                                            <i data-lucide="edit-3" class="w-4 h-4"></i>
                                        </button>
                                        <form :action="'/inventory/' + product.id" method="POST">
                                            @csrf @method('DELETE')
                                            <button type="submit" onclick="return confirm('Delete this product?')" class="w-10 h-10 rounded-xl bg-white/5 border border-white/5 flex items-center justify-center hover:bg-red-500/20 hover:text-red-400 transition-all">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>
        {{-- END max-w-7xl --}}

        {{-- ==================== MODALS ==================== --}}

        {{-- Add Product Modal --}}
        <div x-show="showAddProduct" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-6 bg-black/80 backdrop-blur-md">
            <div @click.away="showAddProduct = false" class="bg-[#111] border border-white/10 p-10 rounded-[40px] max-w-lg w-full space-y-8">
                <h3 class="text-3xl font-black tracking-tighter uppercase text-white text-center">New Product</h3>
                <form action="{{ route('inventory.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    <div class="space-y-2">
                        <div class="flex justify-between items-center ml-4">
                            <label class="text-[10px] font-bold text-white/40 uppercase tracking-widest">Category</label>
                            <button type="button" @click="showQuickCategory = !showQuickCategory" class="text-[10px] font-bold text-white/40 hover:text-white uppercase tracking-widest transition-colors" x-text="showQuickCategory ? '- Hide' : '+ New Category'"></button>
                        </div>
                        <div x-show="showQuickCategory" x-transition class="mb-4 p-4 bg-white/5 rounded-2xl border border-white/5 space-y-3">
                            <input type="text" x-model="newCategoryName" placeholder="Category name..." class="w-full bg-white/5 border border-white/5 rounded-xl py-3 px-4 text-sm text-white focus:ring-0">
                            <button type="button" @click="createNewCategory()" class="w-full py-2 bg-white/10 hover:bg-white/20 text-white text-[10px] font-bold uppercase tracking-widest rounded-xl transition-all">Create Category</button>
                        </div>
                        <select name="category_id" x-model="newProduct.category_id" class="w-full bg-[#1a1a1a] border border-white/10 rounded-2xl py-4 px-6 text-sm text-white focus:ring-0 focus:border-white/20">
                            <template x-for="cat in categories" :key="cat.id">
                                <option :value="cat.id" x-text="cat.name" class="bg-[#1a1a1a] text-white"></option>
                            </template>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-white/40 uppercase tracking-widest ml-4">Product Name</label>
                        <input type="text" name="name" required class="w-full bg-white/5 border border-white/5 rounded-2xl py-4 px-6 text-sm text-white focus:ring-0">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-white/40 uppercase tracking-widest ml-4">Price</label>
                            <input type="number" name="price" min="1" required class="w-full bg-white/5 border border-white/5 rounded-2xl py-4 px-6 text-sm text-white focus:ring-0">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-white/40 uppercase tracking-widest ml-4">Stock</label>
                            <input type="number" name="stock" min="1" required class="w-full bg-white/5 border border-white/5 rounded-2xl py-4 px-6 text-sm text-white focus:ring-0">
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-white/40 uppercase tracking-widest ml-4">Product Image</label>
                        <input type="file" name="image" class="w-full bg-white/5 border border-white/5 rounded-2xl py-4 px-6 text-sm text-white focus:ring-0">
                    </div>
                    <div class="pt-6 flex gap-4">
                        <button type="button" @click="showAddProduct = false" class="flex-1 py-4 border border-white/10 text-white/40 font-bold rounded-2xl uppercase text-[10px]">Cancel</button>
                        <button type="submit" class="flex-1 py-4 bg-white text-black font-black rounded-2xl uppercase text-xs">Add Product</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Edit Product Modal --}}
        <div x-show="showEditProduct" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-6 bg-black/80 backdrop-blur-md">
            <div @click.away="showEditProduct = false" class="bg-[#111] border border-white/10 p-10 rounded-[40px] max-w-lg w-full space-y-8">
                <h3 class="text-3xl font-black tracking-tighter uppercase text-white text-center">Edit Product</h3>
                <form :action="'/inventory/' + editingProduct.id" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf @method('PUT')
                    <div class="space-y-2">
                        <div class="flex justify-between items-center ml-4">
                            <label class="text-[10px] font-bold text-white/40 uppercase tracking-widest">Category</label>
                            <button type="button" @click="showQuickCategory = !showQuickCategory" class="text-[10px] font-bold text-white/40 hover:text-white uppercase tracking-widest transition-colors" x-text="showQuickCategory ? '- Hide' : '+ New Category'"></button>
                        </div>
                        <div x-show="showQuickCategory" x-transition class="mb-4 p-4 bg-white/5 rounded-2xl border border-white/5 space-y-3">
                            <input type="text" x-model="newCategoryName" placeholder="Category name..." class="w-full bg-white/5 border border-white/5 rounded-xl py-3 px-4 text-sm text-white focus:ring-0">
                            <button type="button" @click="createNewCategory()" class="w-full py-2 bg-white/10 hover:bg-white/20 text-white text-[10px] font-bold uppercase tracking-widest rounded-xl transition-all">Create Category</button>
                        </div>
                        <select name="category_id" x-model="editingProduct.category_id" class="w-full bg-[#1a1a1a] border border-white/10 rounded-2xl py-4 px-6 text-sm text-white focus:ring-0 focus:border-white/20">
                            <template x-for="cat in categories" :key="cat.id">
                                <option :value="cat.id" x-text="cat.name" class="bg-[#1a1a1a] text-white"></option>
                            </template>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-white/40 uppercase tracking-widest ml-4">Product Name</label>
                        <input type="text" name="name" x-model="editingProduct.name" required class="w-full bg-white/5 border border-white/5 rounded-2xl py-4 px-6 text-sm text-white focus:ring-0">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-white/40 uppercase tracking-widest ml-4">Price</label>
                            <input type="number" name="price" x-model="editingProduct.price" min="1" required class="w-full bg-white/5 border border-white/5 rounded-2xl py-4 px-6 text-sm text-white focus:ring-0">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-white/40 uppercase tracking-widest ml-4">Stock</label>
                            <input type="number" name="stock" x-model="editingProduct.stock" min="1" required class="w-full bg-white/5 border border-white/5 rounded-2xl py-4 px-6 text-sm text-white focus:ring-0">
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-white/40 uppercase tracking-widest ml-4">Product Image (Leave blank to keep current)</label>
                        <input type="file" name="image" class="w-full bg-white/5 border border-white/5 rounded-2xl py-4 px-6 text-sm text-white focus:ring-0">
                    </div>
                    <div class="pt-6 flex gap-4">
                        <button type="button" @click="showEditProduct = false" class="flex-1 py-4 border border-white/10 text-white/40 font-bold rounded-2xl uppercase text-[10px]">Cancel</button>
                        <button type="submit" class="flex-1 py-4 bg-white text-black font-black rounded-2xl uppercase text-xs">Update Product</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Manage Categories Modal --}}
        <div x-show="showManageCategories" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-6 bg-black/80 backdrop-blur-md">
            <div @click.away="showManageCategories = false" class="bg-[#111] border border-white/10 p-10 rounded-[40px] max-w-md w-full space-y-8">
                <h3 class="text-3xl font-black tracking-tighter uppercase text-white text-center">Categories</h3>
                <form action="{{ route('categories.store') }}" method="POST" class="flex gap-2">
                    @csrf
                    <input type="text" name="name" placeholder="New category..." required class="flex-1 bg-white/5 border border-white/5 rounded-2xl py-3 px-6 text-sm text-white focus:ring-0">
                    <button type="submit" class="p-3 bg-white text-black rounded-2xl"><i data-lucide="plus" class="w-5 h-5"></i></button>
                </form>
                <div class="space-y-2 max-h-60 overflow-y-auto">
                    <template x-for="cat in categories" :key="cat.id">
                        <div class="flex justify-between items-center p-4 bg-white/5 rounded-2xl group">
                            <span class="text-sm font-bold text-white" x-text="cat.name"></span>
                            <form :action="'/categories/' + cat.id" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-400 opacity-0 group-hover:opacity-100 transition-all"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                            </form>
                        </div>
                    </template>
                </div>
                <button @click="showManageCategories = false" class="w-full py-4 border border-white/10 text-white/40 font-bold rounded-2xl uppercase text-[10px]">Close</button>
            </div>
        </div>

        {{-- Restock Modal --}}
        <div x-show="showRestock" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-6 bg-black/80 backdrop-blur-md">
            <div @click.away="showRestock = false" class="bg-[#111] border border-white/10 p-10 rounded-[40px] max-w-sm w-full space-y-8">
                <h3 class="text-3xl font-black tracking-tighter uppercase text-white text-center">Restock Item</h3>
                <form action="{{ route('inventory.restock') }}" method="POST" class="space-y-6">
                    @csrf
                    <input type="hidden" name="product_id" :value="selectedProduct">
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-white/40 uppercase tracking-widest ml-4">Quantity to Add</label>
                        <input type="number" name="qty" min="1" required class="w-full bg-white/5 border border-white/5 rounded-2xl py-4 px-6 text-sm text-white focus:ring-0" placeholder="0">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-white/40 uppercase tracking-widest ml-4">Supplier (Optional)</label>
                        <input type="text" name="supplier" class="w-full bg-white/5 border border-white/5 rounded-2xl py-4 px-6 text-sm text-white focus:ring-0" placeholder="Vendor name">
                    </div>
                    <button type="submit" class="w-full py-4 bg-white text-black font-black rounded-2xl uppercase text-xs">Confirm Restock</button>
                </form>
            </div>
        </div>

    </div>
    {{-- END x-data --}}

    <script>
        function inventorySystem() {
            return {
                products: @json($products),
                categories: @json($categories),
                search: '',
                selectedCategory: 'all',
                showAddProduct: false,
                showEditProduct: false,
                showManageCategories: false,
                showRestock: false,
                showQuickCategory: false,
                newCategoryName: '',
                selectedProduct: null,
                newProduct: {
                    category_id: '',
                },
                editingProduct: {
                    id: null,
                    name: '',
                    category_id: '',
                    price: 0,
                    stock: 0
                },

                init() {
                    if (this.categories.length > 0) {
                        this.newProduct.category_id = this.categories[0].id;
                    }
                    this.$nextTick(() => lucide.createIcons());
                },

                get filteredProducts() {
                    return this.products.filter(p => {
                        const matchSearch = p.name.toLowerCase().includes(this.search.toLowerCase());
                        const matchCategory = this.selectedCategory === 'all' || p.category_id === this.selectedCategory;
                        return matchSearch && matchCategory;
                    });
                },

                editProduct(product) {
                    this.editingProduct = { ...product };
                    this.showEditProduct = true;
                },

                async createNewCategory() {
                    if (!this.newCategoryName) return;

                    try {
                        const response = await fetch('{{ route("categories.store") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({ name: this.newCategoryName })
                        });

                        const data = await response.json();

                        if (response.ok) {
                            const exists = this.categories.find(c => c.id === data.category.id);
                            if (!exists) {
                                this.categories.push(data.category);
                            }
                            
                            const newCatId = data.category.id;
                            this.newCategoryName = '';
                            this.showQuickCategory = false;

                            // Auto-select the category in the dropdown via x-model
                            if (this.showAddProduct) {
                                this.newProduct.category_id = newCatId;
                            } else if (this.showEditProduct) {
                                this.editingProduct.category_id = newCatId;
                            }
                        } else {
                            alert(data.message || 'Error creating category');
                        }
                    } catch (error) {
                        console.error(error);
                        location.reload();
                    }
                }
            }
        }
    </script>
    <style>[x-cloak] { display: none !important; }</style>
</x-app-layout>
