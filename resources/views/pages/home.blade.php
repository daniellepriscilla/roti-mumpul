@extends('layouts.app')

@section('title', 'Roti Mumpul - Kelembutan Sempurna Khas Vintage')

@section('content')
@if(session('success') || session('error'))
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">
        @if(session('success'))
            <div class="bg-mumpul-green text-mumpul-cream p-4 rounded-xl shadow font-medium text-sm text-center">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-700 text-white p-4 rounded-xl shadow font-medium text-sm text-center">
                {{ session('error') }}
            </div>
        @endif
    </div>
@endif

<!-- Hero Section -->
<section class="bg-mumpul-maroon text-mumpul-cream py-12 md:py-20 border-b-4 border-mumpul-yellow relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-10">
        
        <!-- Text & Tagline -->
        <div class="md:w-1/2 space-y-6 text-center md:text-left">
            <h1 class="font-serif text-4xl sm:text-5xl lg:text-6xl font-extrabold text-mumpul-cream leading-tight">
                Roti Pulen, Rasa Jadul. 
            </h1>
            <p class="text-mumpul-cream/90 text-base sm:text-lg leading-relaxed font-sans">
                Menghidupkan kembali memori pulang melalui setiap gigitan.
                Dibuat fresh setiap pagi dengan resep tradisional dan bahan-bahan pilihan yang menghangatkan hati.
                <br>Amankan Roti Mumpul anda hari ini! 
            </p>
            <div class="flex flex-col sm:flex-row justify-center md:justify-start gap-4 pt-2">
                <a href="{{ route('products.index') }}" class="bg-mumpul-green hover:bg-mumpul-greenHover text-mumpul-cream font-bold px-7 py-3.5 rounded-xl shadow-lg border border-mumpul-cream/20 transition text-center text-sm">
                    Menu
                </a>
                <a href="{{ route('events') }}" class="bg-mumpul-cream hover:bg-mumpul-yellow text-mumpul-maroon font-serif font-bold px-7 py-3.5 rounded-xl transition text-center text-sm shadow">
                    Kunjungi Kami
                </a>
            </div>
        </div>

        <!-- Poster Image / Illustration -->
        <div class="md:w-1/2 relative">
            <div class="bg-mumpul-yellow/30 absolute -inset-2 rounded-3xl blur-lg transform -rotate-2"></div>
            <img src="{{ asset('images/hero-roti.jpg') }}" 
                 alt="Roti Mumpul Freshly Baked" 
                 class="relative rounded-2xl shadow-2xl w-full max-h-[420px] object-cover border-4 border-mumpul-cream">
        </div>

    </div>
</section>

<!-- About Section -->
<section class="py-16 bg-mumpul-cream">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-6">
        <span class="text-mumpul-maroon font-serif font-bold text-sm tracking-widest uppercase">Tentang Kami</span>
        <h2 class="font-serif text-3xl sm:text-4xl font-extrabold text-mumpul-maroon">Mengenal Roti Mumpul</h2>
        <p class="text-mumpul-text leading-relaxed text-base sm:text-lg max-w-3xl mx-auto">
            Lahir dari resep otentik pilihan, <strong class="text-mumpul-maroon font-serif">Roti Mumpul</strong> mengutamakan kualitas bahan terbaik demi menghasilkan adonan yang mengembang sempurna dan tekstur yang sangat empuk (<em>mumpul</em>).

        <!-- Value / Highlight Features -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 pt-8 text-left">
            <div class="bg-white p-6 rounded-2xl border-2 border-mumpul-maroon/20 shadow-md">
                <div class="w-12 h-12 bg-mumpul-yellow text-mumpul-maroon rounded-xl flex items-center justify-center font-bold text-xl mb-4 border border-mumpul-maroon/20 shadow-sm">✨</div>
                <h3 class="font-serif font-bold text-mumpul-maroon text-lg mb-1">Tekstur Mumpul</h3>
                <p class="text-mumpul-text text-sm">Adonan lembut bernutrisi yang mengembang alami dan nikmat dikonsumsi.</p>
            </div>
            <div class="bg-white p-6 rounded-2xl border-2 border-mumpul-maroon/20 shadow-md">
                <div class="w-12 h-12 bg-mumpul-yellow text-mumpul-maroon rounded-xl flex items-center justify-center font-bold text-xl mb-4 border border-mumpul-maroon/20 shadow-sm">🌿</div>
                <h3 class="font-serif font-bold text-mumpul-maroon text-lg mb-1">Tanpa Pengawet</h3>
                <p class="text-mumpul-text text-sm">Menggunakan bahan berkualitas tinggi yang aman untuk seluruh anggota keluarga.</p>
            </div>
            <div class="bg-white p-6 rounded-2xl border-2 border-mumpul-maroon/20 shadow-md">
                <div class="w-12 h-12 bg-mumpul-yellow text-mumpul-maroon rounded-xl flex items-center justify-center font-bold text-xl mb-4 border border-mumpul-maroon/20 shadow-sm">🔥</div>
                <h3 class="font-serif font-bold text-mumpul-maroon text-lg mb-1">Fresh Every Day</h3>
                <p class="text-mumpul-text text-sm">Dipanggang setiap hari untuk menjaga kesegaran rasa dan aroma terbaik.</p>
            </div>
        </div>
    </div>
</section>

<!-- Best Seller Section -->
<section class="py-16 bg-mumpul-maroon/5 border-t border-mumpul-maroon/10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" x-data="{ selectedProduct: null }">
        <div class="flex flex-col md:flex-row justify-between items-center mb-10">
            <div>
                <h2 class="font-serif text-3xl font-extrabold text-mumpul-maroon mt-1">Best Seller Variant</h2>
            </div>
            <a href="{{ route('products.index') }}" class="mt-4 md:mt-0 text-mumpul-maroon font-serif font-bold text-sm hover:underline flex items-center gap-1">
                Lihat Semua Varian &rarr;
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($bestSellers as $product)
                <div class="bg-mumpul-cream border-2 border-mumpul-maroon rounded-2xl p-5 shadow-lg relative flex flex-col justify-between">
                    
                    <!-- Header Kategori & Badge Best Seller -->
                    <div>
                        <div class="flex justify-between items-center mb-3">
                            <span class="bg-mumpul-yellow text-mumpul-maroon font-bold font-serif px-3 py-1 rounded-md text-xs tracking-wide border border-mumpul-maroon/30 shadow-sm">
                                {{ $product->category->name }}
                            </span>
                            <span class="bg-mumpul-green text-mumpul-cream text-[10px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wider">
                                Best Seller
                            </span>
                        </div>

                        <!-- Gambar & Detail Produk -->
                        <div class="text-center">
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-40 object-cover rounded-xl border border-mumpul-maroon/20 mb-3 shadow-inner">
                            <h3 class="font-serif font-bold text-xl text-mumpul-maroon">{{ $product->name }}</h3>
                            <p class="text-mumpul-text text-sm mt-1 line-clamp-2">{{ $product->description }}</p>
                        </div>
                    </div>

                    <!-- Harga & Tombol Aksi -->
                    <div class="mt-4 pt-3 border-t border-mumpul-maroon/20 flex items-center justify-between">
                        <span class="font-serif font-bold text-lg text-mumpul-maroon">
                            IDR {{ number_format($product->price, 0, ',', '.') }}
                        </span>
                        
                        <button @click="selectedProduct = {{ $product->toJson() }}" class="bg-mumpul-green hover:bg-mumpul-greenHover text-mumpul-cream font-bold px-3 py-2 rounded-xl text-xs transition shadow border border-mumpul-cream/20">
                            Beli
                        </button>
                    </div>

                </div>
            @empty
                <div class="col-span-full text-center py-8 text-mumpul-text font-serif">
                    Belum ada produk best seller yang ditandai.
                </div>
            @endforelse
        </div>

        <!-- Pop Up Modal Detail Produk -->
        @include('components.product-modal')
    </div>
</section>

<!-- Banner CFD Tunjungan -->
<section class="py-12 bg-mumpul-maroon text-mumpul-cream relative overflow-hidden border-t-4 border-mumpul-yellow">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="space-y-2 text-center md:text-left">
            <span class="bg-mumpul-yellow text-mumpul-maroon font-serif text-xs font-extrabold px-3 py-1 rounded-full uppercase shadow">Sunday Event</span>
            <h2 class="font-serif text-2xl sm:text-3xl font-bold">Mumpul di CFD Tunjungan Surabaya!</h2>
            <p class="text-mumpul-cream/80 text-sm max-w-2xl">
                Nikmati kehangatan Roti Mumpul secara langsung setiap hari Minggu pagi di Jalan Tunjungan Surabaya (06.00 - Selesai)
            </p>
        </div>
        <a href="{{ route('events') }}" class="bg-mumpul-green hover:bg-mumpul-greenHover text-mumpul-cream font-bold px-6 py-3 rounded-xl transition text-sm whitespace-nowrap border border-mumpul-cream/20 shadow-lg">
            Cek Detail Event
        </a>
    </div>
</section>
@endsection