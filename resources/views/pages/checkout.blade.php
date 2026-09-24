@extends('layouts.app')

@section('title', 'Checkout & Pembayaran - Roti Mumpul')

@section('content')
<div class="bg-mumpul-cream/30 min-h-screen py-12">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="font-serif text-3xl md:text-4xl font-extrabold text-mumpul-maroon mb-2">
            🧾 Checkout & Pembayaran
        </h1>
        <p class="text-mumpul-text text-sm mb-8">Periksa kembali pesananmu, lalu pilih metode pembayaran.</p>

        @if(session('error'))
            <div class="bg-red-700 text-white p-4 rounded-xl mb-6 shadow font-medium text-sm">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Detail Pesanan -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Item -->
                <div class="bg-mumpul-cream border-2 border-mumpul-maroon rounded-3xl p-6 shadow-xl">
                    <h2 class="font-serif font-bold text-xl text-mumpul-maroon border-b border-mumpul-maroon/20 pb-3 mb-4">
                        Item Pesanan
                    </h2>

                    <ul class="divide-y divide-mumpul-maroon/10">
                        @foreach($cartItems as $item)
                            <li class="py-3 flex items-center gap-4">
                                <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" class="w-14 h-14 object-cover rounded-lg border border-mumpul-maroon/20">
                                <div class="flex-1">
                                    <p class="font-serif font-bold text-mumpul-maroon">{{ $item->product->name }}</p>
                                    <p class="text-xs text-mumpul-text">{{ $item->quantity }} pcs &times; IDR {{ number_format($item->product->price, 0, ',', '.') }}</p>
                                </div>
                                <span class="font-bold text-mumpul-maroon text-sm">
                                    IDR {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Data Pemesanan -->
                <div class="bg-mumpul-cream border-2 border-mumpul-maroon rounded-3xl p-6 shadow-xl">
                    <div class="flex items-center justify-between border-b border-mumpul-maroon/20 pb-3 mb-4">
                        <h2 class="font-serif font-bold text-xl text-mumpul-maroon">Data Pemesanan</h2>
                        <a href="{{ route('cart.index') }}" class="text-xs font-bold text-mumpul-maroon hover:underline">Ubah</a>
                    </div>

                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                        <div>
                            <dt class="text-mumpul-text/70 font-semibold">Nama Pemesan</dt>
                            <dd class="font-bold text-mumpul-maroon">{{ $checkoutData['customer_name'] }}</dd>
                        </div>
                        <div>
                            <dt class="text-mumpul-text/70 font-semibold">Nomor WhatsApp</dt>
                            <dd class="font-bold text-mumpul-maroon">{{ $checkoutData['whatsapp_number'] }}</dd>
                        </div>
                        <div>
                            <dt class="text-mumpul-text/70 font-semibold">Metode Pengambilan</dt>
                            <dd class="font-bold text-mumpul-maroon">{{ $checkoutData['fulfillment_type'] === 'delivery' ? 'Delivery' : 'Pick Up' }}</dd>
                        </div>
                        <div>
                            <dt class="text-mumpul-text/70 font-semibold">Tanggal & Jam</dt>
                            <dd class="font-bold text-mumpul-maroon">{{ \Carbon\Carbon::parse($checkoutData['fulfillment_date'])->format('d M Y') }}, {{ \Carbon\Carbon::parse($checkoutData['fulfillment_time'])->format('H:i') }} WIB</dd>
                        </div>
                        @if(($checkoutData['fulfillment_type'] ?? '') === 'delivery' && !empty($checkoutData['address']))
                            <div class="sm:col-span-2">
                                <dt class="text-mumpul-text/70 font-semibold">Alamat Pengiriman</dt>
                                <dd class="font-bold text-mumpul-maroon">{{ $checkoutData['address'] }}</dd>
                            </div>
                        @endif
                        @if(!empty($checkoutData['notes']))
                            <div class="sm:col-span-2">
                                <dt class="text-mumpul-text/70 font-semibold">Catatan Khusus</dt>
                                <dd class="font-bold text-mumpul-maroon">{{ $checkoutData['notes'] }}</dd>
                            </div>
                        @endif
                    </dl>
                </div>
            </div>

            <!-- Ringkasan & Payment Method -->
            <div class="bg-mumpul-cream border-2 border-mumpul-maroon rounded-3xl p-6 shadow-xl h-fit space-y-5 lg:sticky lg:top-24">
                <h2 class="font-serif font-bold text-xl text-mumpul-maroon border-b border-mumpul-maroon/20 pb-3">
                    Ringkasan & Pembayaran
                </h2>

                <div class="flex justify-between text-mumpul-text text-sm">
                    <span>Total Item</span>
                    <span class="font-bold text-mumpul-maroon">{{ $totalQuantity }} pcs</span>
                </div>

                <div class="flex justify-between text-mumpul-maroon font-serif font-bold text-xl border-t border-mumpul-maroon/20 pt-3">
                    <span>Total</span>
                    <span>IDR {{ number_format($totalAmount, 0, ',', '.') }}</span>
                </div>

                <form action="{{ route('checkout.process') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <span class="block font-serif font-bold text-mumpul-maroon text-sm mb-2">Metode Pembayaran</span>
                        <div class="space-y-2">
                            <label class="border-2 border-mumpul-maroon/30 rounded-xl p-3 flex items-center gap-3 cursor-pointer hover:bg-mumpul-yellow/20 transition">
                                <input type="radio" name="payment_method" value="transfer" {{ old('payment_method', 'transfer') === 'transfer' ? 'checked' : '' }} required class="text-mumpul-maroon focus:ring-mumpul-maroon">
                                <div>
                                    <span class="font-serif font-bold text-mumpul-maroon block text-sm">Transfer Bank</span>
                                    <span class="text-xs text-mumpul-text">BCA / Mandiri &mdash; detail dikirim via WhatsApp</span>
                                </div>
                            </label>

                            <label class="border-2 border-mumpul-maroon/30 rounded-xl p-3 flex items-center gap-3 cursor-pointer hover:bg-mumpul-yellow/20 transition">
                                <input type="radio" name="payment_method" value="qris" {{ old('payment_method') === 'qris' ? 'checked' : '' }} class="text-mumpul-maroon focus:ring-mumpul-maroon">
                                <div>
                                    <span class="font-serif font-bold text-mumpul-maroon block text-sm">QRIS</span>
                                    <span class="text-xs text-mumpul-text">Scan kode QR di booth / link dikirim via WA</span>
                                </div>
                            </label>

                            <label class="border-2 border-mumpul-maroon/30 rounded-xl p-3 flex items-center gap-3 cursor-pointer hover:bg-mumpul-yellow/20 transition">
                                <input type="radio" name="payment_method" value="cod" {{ old('payment_method') === 'cod' ? 'checked' : '' }} class="text-mumpul-maroon focus:ring-mumpul-maroon">
                                <div>
                                    <span class="font-serif font-bold text-mumpul-maroon block text-sm">Bayar di Tempat (COD)</span>
                                    <span class="text-xs text-mumpul-text">Saat pick up atau terima kiriman</span>
                                </div>
                            </label>
                        </div>
                        @error('payment_method')
                            <p class="text-red-600 text-xs mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                            class="block w-full text-center bg-mumpul-green hover:bg-mumpul-greenHover text-mumpul-cream font-bold py-3 rounded-xl transition shadow border border-mumpul-cream/20">
                        Konfirmasi & Buat Pesanan
                    </button>
                </form>

                <a href="{{ route('cart.index') }}" class="block w-full text-center font-serif text-sm text-mumpul-maroon font-bold hover:underline py-1">
                    &larr; Kembali ke Keranjang
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
