@extends('layouts.app')

@section('title', 'Buku Menu - Roti Mumpul')

@section('content')
<div class="bg-mumpul-cream/40 min-h-screen py-12" x-data="{ activeTab: 'all', selectedProduct: null }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header Buku Menu -->
        <div class="text-center max-w-2xl mx-auto mb-12">
            <h1 class="font-serif text-4xl sm:text-5xl font-extrabold text-mumpul-maroon">Pilihan Menu Kami</h1>
            <p class="text-mumpul-text mt-3 text-base leading-relaxed">
                Pilih seri rasa kesukaanmu dari Seri Legi, Seri Gurih, hingga Seri Kering.
                <br> Dibuat fresh setiap hari dengan cinta.
            </p>
        </div>

        @if(session('success'))
            <div class="max-w-3xl mx-auto bg-mumpul-green text-mumpul-cream p-4 rounded-xl mb-6 shadow font-medium text-sm text-center">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="max-w-3xl mx-auto bg-red-700 text-white p-4 rounded-xl mb-6 shadow font-medium text-sm text-center">
                {{ session('error') }}
            </div>
        @endif

        <!-- Filter Kategori -->
        <div class="flex flex-wrap justify-center gap-3 mb-10">
            <button @click="activeTab = 'all'"
                    :class="activeTab === 'all' ? 'bg-mumpul-maroon text-mumpul-cream' : 'bg-mumpul-cream text-mumpul-maroon hover:bg-mumpul-yellow/50'"
                    class="font-serif font-bold text-sm px-5 py-2.5 rounded-xl border border-mumpul-maroon/30 transition shadow-sm">
                Semua Seri
            </button>
            @foreach($categories as $category)
                <button @click="activeTab = 'cat-{{ $category->id }}'"
                        :class="activeTab === 'cat-{{ $category->id }}' ? 'bg-mumpul-maroon text-mumpul-cream' : 'bg-mumpul-cream text-mumpul-maroon hover:bg-mumpul-yellow/50'"
                        class="font-serif font-bold text-sm px-5 py-2.5 rounded-xl border border-mumpul-maroon/30 transition shadow-sm">
                    {{ $category->name }}
                </button>
            @endforeach
        </div>

        <!-- Grid Produk -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($products as $product)
                <div x-show="activeTab === 'all' || activeTab === 'cat-{{ $product->category_id }}'"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     class="bg-mumpul-cream border-2 border-mumpul-maroon rounded-2xl p-6 shadow-lg relative flex flex-col justify-between hover:shadow-xl transition-all duration-200">

                    <!-- Top Badge / Header Card -->
                    <div>
                        <div class="flex justify-between items-center mb-3">
                            <span class="bg-mumpul-yellow text-mumpul-maroon font-bold font-serif px-3 py-1 rounded-md text-xs tracking-wide border border-mumpul-maroon/30 shadow-sm">
                                {{ $product->category->name }}
                            </span>
                            @if($product->is_best_seller)
                                <span class="bg-mumpul-green text-mumpul-cream text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wider shadow-sm">
                                    Best Seller
                                </span>
                            @endif
                        </div>

                        <!-- Foto & Info Produk -->
                        <div class="text-center cursor-pointer" @click="selectedProduct = {{ $product->toJson() }}">
                            <img src="{{ $product->image_url }}"
                                 alt="{{ $product->name }}"
                                 class="w-full h-48 object-cover rounded-xl border border-mumpul-maroon/20 mb-4 shadow-inner">
                            <h3 class="font-serif font-bold text-2xl text-mumpul-maroon">{{ $product->name }}</h3>
                            <p class="text-mumpul-text text-sm mt-2 leading-relaxed min-h-[40px]">{{ $product->description }}</p>
                        </div>
                    </div>

                    <!-- Footer Card (Harga & Tombol Order) -->
                    <div class="mt-6 pt-4 border-t border-mumpul-maroon/20 flex items-center justify-between">
                        <div>
                            <span class="text-[11px] text-mumpul-text/70 uppercase font-semibold block">Harga</span>
                            <span class="font-serif font-bold text-xl text-mumpul-maroon">
                                IDR {{ number_format($product->price, 0, ',', '.') }}
                            </span>
                        </div>

                        @auth
                            <button type="button" @click="selectedProduct = {{ $product->toJson() }}"
                                    class="bg-mumpul-green hover:bg-mumpul-greenHover text-mumpul-cream font-bold px-3 py-1.5 rounded-xl text-sm transition shadow border border-mumpul-cream/20 flex items-center gap-1.5">
                                +
                            </button>
                        @else
                            <a href="{{ route('login') }}" class="bg-mumpul-green hover:bg-mumpul-greenHover text-mumpul-cream font-bold px-5 py-2.5 rounded-xl text-sm transition shadow border border-mumpul-cream/20">
                                Login untuk Beli
                            </a>
                        @endauth
                    </div>

                </div>
            @empty
                <div class="col-span-full text-center py-16 bg-white/50 rounded-2xl border border-mumpul-maroon/20">
                    <p class="font-serif text-lg text-mumpul-maroon font-bold">Belum ada varian produk di buku menu.</p>
                </div>
            @endforelse
        </div>

        <!-- Pop Up Modal Detail Produk -->
        @include('components.product-modal')

    </div>
</div>
@endsection
