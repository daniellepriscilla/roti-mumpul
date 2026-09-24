@extends('layouts.app')

@section('title', 'Keranjang Belanja - Roti Mumpul')

@section('content')
<div class="bg-mumpul-cream/30 min-h-screen py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="font-serif text-3xl md:text-4xl font-extrabold text-mumpul-maroon mb-8">
            Keranjang Belanja
        </h1>

        @if(session('success'))
            <div class="bg-mumpul-green text-mumpul-cream p-4 rounded-xl mb-6 shadow font-medium text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-700 text-white p-4 rounded-xl mb-6 shadow font-medium text-sm">
                {{ session('error') }}
            </div>
        @endif

        @if($cartItems->count() > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Kolom Kiri: Item + Formulir Pemesanan -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Daftar Item Roti -->
                    <div class="space-y-4">
                        @foreach($cartItems as $item)
                            <div class="bg-mumpul-cream border-2 border-mumpul-maroon/30 rounded-2xl p-4 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                <div class="flex items-center gap-4 flex-1">
                                    <img src="{{ $item->product->image_url }}"
                                         alt="{{ $item->product->name }}"
                                         class="w-20 h-20 object-cover rounded-xl border border-mumpul-maroon/20">

                                    <div class="flex-1">
                                        <h3 class="font-serif font-bold text-lg text-mumpul-maroon">{{ $item->product->name }}</h3>
                                        <p class="text-sm font-semibold text-mumpul-maroon/80 mt-0.5">
                                            {{ $item->quantity }} &times; IDR {{ number_format($item->product->price, 0, ',', '.') }}
                                        </p>
                                        <p class="text-sm font-extrabold text-mumpul-maroon">
                                            = IDR {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Form Update / Hapus Quantity -->
                                <div class="flex items-center gap-3">
                                    <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="20" class="w-16 rounded-xl border-2 border-mumpul-maroon/30 bg-white text-center font-bold text-mumpul-maroon py-1">
                                        <button type="submit" class="text-xs bg-mumpul-maroon text-mumpul-cream font-bold px-2.5 py-1.5 rounded-lg hover:bg-mumpul-maroon/90">
                                            Update
                                        </button>
                                    </form>

                                    <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 font-bold text-sm px-2" title="Hapus item">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach

                        <p class="text-xs text-mumpul-text/70 text-right">
                            Maksimal pembelian {{ \App\Http\Controllers\CartController::MAX_ITEMS }} pcs &middot; lebih dari itu? Pesan melalui <a href="https://wa.me/{{ config('services.whatsapp.number') }}" target="_blank" rel="noopener noreferrer" class="text-mumpul-maroon font-bold underline">Bulk Order</a>
                        </p>
                    </div>

                    <!-- Formulir Pemesanan -->
                    <form id="form-pemesanan" action="{{ route('checkout.review') }}" method="POST"
                          x-data="{ fulfillmentType: '{{ old('fulfillment_type', 'pickup') }}' }">
                        @csrf

                        <div class="bg-mumpul-cream border-2 border-mumpul-maroon rounded-3xl p-6 md:p-8 shadow-xl space-y-6">
                            <h2 class="font-serif font-bold text-xl text-mumpul-maroon border-b border-mumpul-maroon/20 pb-3">
                                Formulir Pemesanan
                            </h2>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="customer_name" class="block font-serif font-bold text-mumpul-maroon text-sm mb-1">Nama Pemesan</label>
                                    <input type="text" id="customer_name" name="customer_name" value="{{ old('customer_name', Auth::user()->name) }}" required
                                           class="w-full rounded-xl border-2 border-mumpul-maroon/30 bg-white p-2.5 font-medium text-mumpul-text focus:border-mumpul-maroon focus:ring-mumpul-maroon">
                                    @error('customer_name')
                                        <p class="text-red-600 text-xs mt-1 font-semibold">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="whatsapp_number" class="block font-serif font-bold text-mumpul-maroon text-sm mb-1">Nomor WhatsApp</label>
                                    <input type="text" id="whatsapp_number" name="whatsapp_number" value="{{ old('whatsapp_number') }}" placeholder="08123456789" required
                                           class="w-full rounded-xl border-2 border-mumpul-maroon/30 bg-white p-2.5 font-medium text-mumpul-text focus:border-mumpul-maroon focus:ring-mumpul-maroon">
                                    @error('whatsapp_number')
                                        <p class="text-red-600 text-xs mt-1 font-semibold">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Metode Pengambilan -->
                            <div>
                                <label class="block font-serif font-bold text-mumpul-maroon mb-2">Metode Pengambilan</label>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <label class="border-2 rounded-2xl p-4 flex items-center gap-3 cursor-pointer transition"
                                           :class="fulfillmentType === 'pickup' ? 'border-mumpul-maroon bg-mumpul-yellow/30' : 'border-mumpul-maroon/30 hover:bg-mumpul-yellow/10'">
                                        <input type="radio" name="fulfillment_type" value="pickup" x-model="fulfillmentType"
                                               {{ old('fulfillment_type', 'pickup') === 'pickup' ? 'checked' : '' }}
                                               class="text-mumpul-maroon focus:ring-mumpul-maroon">
                                        <div>
                                            <span class="font-serif font-bold text-mumpul-maroon block">Pick Up</span>
                                            <span class="text-xs text-mumpul-text">Ambil langsung di booth / toko</span>
                                        </div>
                                    </label>

                                    <label class="border-2 rounded-2xl p-4 flex items-center gap-3 cursor-pointer transition"
                                           :class="fulfillmentType === 'delivery' ? 'border-mumpul-maroon bg-mumpul-yellow/30' : 'border-mumpul-maroon/30 hover:bg-mumpul-yellow/10'">
                                        <input type="radio" name="fulfillment_type" value="delivery" x-model="fulfillmentType"
                                               {{ old('fulfillment_type') === 'delivery' ? 'checked' : '' }}
                                               class="text-mumpul-maroon focus:ring-mumpul-maroon">
                                        <div>
                                            <span class="font-serif font-bold text-mumpul-maroon block">Delivery</span>
                                            <span class="text-xs text-mumpul-text">Dikirim via kurir ke alamat kamu</span>
                                        </div>
                                    </label>
                                </div>
                                @error('fulfillment_type')
                                    <p class="text-red-600 text-xs mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="fulfillment_date" class="block font-serif font-bold text-mumpul-maroon text-sm mb-1">Tanggal Pengambilan / Pengiriman</label>
                                    <input type="date" id="fulfillment_date" name="fulfillment_date" value="{{ old('fulfillment_date') }}" min="{{ date('Y-m-d') }}" required
                                           class="w-full rounded-xl border-2 border-mumpul-maroon/30 bg-white p-2.5 font-medium text-mumpul-text focus:border-mumpul-maroon focus:ring-mumpul-maroon">
                                    @error('fulfillment_date')
                                        <p class="text-red-600 text-xs mt-1 font-semibold">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="fulfillment_time" class="block font-serif font-bold text-mumpul-maroon text-sm mb-1">Jam Pengiriman / Pengambilan</label>
                                    <input type="time" id="fulfillment_time" name="fulfillment_time" value="{{ old('fulfillment_time') }}" required
                                           class="w-full rounded-xl border-2 border-mumpul-maroon/30 bg-white p-2.5 font-medium text-mumpul-text focus:border-mumpul-maroon focus:ring-mumpul-maroon">
                                    @error('fulfillment_time')
                                        <p class="text-red-600 text-xs mt-1 font-semibold">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Alamat (khusus delivery) -->
                            <div x-show="fulfillmentType === 'delivery'" x-cloak x-transition>
                                <label for="address" class="block font-serif font-bold text-mumpul-maroon text-sm mb-1">Alamat Lengkap</label>
                                <textarea id="address" name="address" rows="3" placeholder="Nama jalan, nomor rumah, kelurahan, kecamatan, kota, patokan..."
                                          class="w-full rounded-xl border-2 border-mumpul-maroon/30 bg-white p-2.5 font-medium text-mumpul-text focus:border-mumpul-maroon focus:ring-mumpul-maroon">{{ old('address') }}</textarea>
                                @error('address')
                                    <p class="text-red-600 text-xs mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="notes" class="block font-serif font-bold text-mumpul-maroon text-sm mb-1">Catatan Khusus</label>
                                <textarea id="notes" name="notes" rows="3" placeholder="Contoh: tolong dipisah kardus, jangan lupa lilin ulang tahun, dll."
                                          class="w-full rounded-xl border-2 border-mumpul-maroon/30 bg-white p-2.5 font-medium text-mumpul-text focus:border-mumpul-maroon focus:ring-mumpul-maroon">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <p class="text-red-600 text-xs mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Ringkasan Belanja & Checkout -->
                <div class="bg-mumpul-cream border-2 border-mumpul-maroon rounded-2xl p-6 shadow-md h-fit space-y-4 lg:sticky lg:top-24">
                    <h2 class="font-serif font-bold text-xl text-mumpul-maroon border-b border-mumpul-maroon/20 pb-3">
                        Ringkasan Pesanan
                    </h2>

                    <div class="flex justify-between text-mumpul-text text-sm">
                        <span>Total Jumlah Item</span>
                        <span class="font-bold text-mumpul-maroon">{{ $totalQuantity }} pcs</span>
                    </div>

                    <div class="flex justify-between text-mumpul-maroon font-serif font-bold text-lg border-t border-mumpul-maroon/20 pt-3">
                        <span>Total Harga</span>
                        <span>IDR {{ number_format($totalAmount, 0, ',', '.') }}</span>
                    </div>

                    <button type="submit" form="form-pemesanan"
                            class="block w-full text-center bg-mumpul-green hover:bg-mumpul-greenHover text-mumpul-cream font-bold py-3 rounded-xl transition shadow border border-mumpul-cream/20 mt-4">
                        Checkout &rarr;
                    </button>

                    <a href="{{ route('products.index') }}" class="block w-full text-center text-mumpul-maroon font-serif font-bold text-sm hover:underline py-1">
                        &larr; Tambah varian lain
                    </a>
                </div>
            </div>
        @else
            <div class="text-center py-16 bg-mumpul-cream/60 rounded-3xl border-2 border-mumpul-maroon/20 p-8">
                <p class="font-serif text-2xl font-bold text-mumpul-maroon">Keranjang belanjamu masih kosong</p>
                <p class="text-mumpul-text text-sm mt-2">Yuk, pilih varian roti favoritmu di buku menu!</p>
                <a href="{{ route('products.index') }}" class="inline-block mt-6 bg-mumpul-green text-mumpul-cream font-bold px-6 py-3 rounded-xl shadow hover:bg-mumpul-greenHover transition">
                    Lihat Menu
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
