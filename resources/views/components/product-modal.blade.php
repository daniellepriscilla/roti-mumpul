<!-- Modal Detail Produk -->
<div x-show="selectedProduct"
     x-cloak
     class="fixed inset-0 z-50 overflow-y-auto bg-black/50 backdrop-blur-sm flex items-center justify-center p-4"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0">

    <div class="bg-mumpul-cream rounded-2xl max-w-lg w-full p-6 shadow-2xl border-2 border-mumpul-maroon relative" @click.away="selectedProduct = null">
        <!-- Tombol Close -->
        <button @click="selectedProduct = null" class="absolute top-4 right-4 text-mumpul-maroon/60 hover:text-mumpul-maroon">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>

        <template x-if="selectedProduct">
            <div>
                <img :src="selectedProduct.image_url" :alt="selectedProduct.name" class="w-full h-56 object-cover rounded-xl mb-4 border border-mumpul-maroon/20">
                <span class="text-xs font-bold text-mumpul-maroon bg-mumpul-yellow px-2.5 py-1 rounded-md border border-mumpul-maroon/30" x-text="selectedProduct.category ? selectedProduct.category.name : 'Roti Mumpul'"></span>
                <h3 class="font-serif text-xl font-bold text-mumpul-maroon mt-2" x-text="selectedProduct.name"></h3>
                <p class="text-mumpul-text text-sm mt-2 leading-relaxed" x-text="selectedProduct.description"></p>

                <div class="mt-6 flex items-center justify-between border-t border-mumpul-maroon/20 pt-4">
                    <div>
                        <span class="text-xs text-mumpul-text/70 block">Harga</span>
                        <span class="font-serif text-lg font-bold text-mumpul-maroon" x-text="'Rp ' + new Intl.NumberFormat('id-ID').format(Number(selectedProduct.price))"></span>
                    </div>

                    @auth
                        <form :action="'{{ url('cart/add') }}/' + selectedProduct.id" method="POST">
                            @csrf
                            <button type="submit" class="bg-mumpul-green hover:bg-mumpul-greenHover text-mumpul-cream font-bold px-5 py-2.5 rounded-xl text-sm transition shadow border border-mumpul-cream/20">
                                Beli &rarr; Keranjang
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="bg-mumpul-green hover:bg-mumpul-greenHover text-mumpul-cream font-bold px-5 py-2.5 rounded-xl text-sm transition shadow border border-mumpul-cream/20">
                            Login untuk Membeli
                        </a>
                    @endauth
                </div>
            </div>
        </template>
    </div>
</div>
