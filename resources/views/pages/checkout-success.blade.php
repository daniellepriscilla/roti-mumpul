@extends('layouts.app')

@section('title', 'Pesanan Berhasil - Roti Mumpul')

@section('content')
<div class="bg-mumpul-cream/30 min-h-screen py-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Success Header -->
        <div class="bg-mumpul-cream border-2 border-mumpul-maroon rounded-3xl p-8 md:p-10 shadow-xl text-center">
            <div class="w-20 h-20 bg-mumpul-green text-mumpul-cream rounded-full flex items-center justify-center mx-auto mb-6 border-4 border-mumpul-yellow shadow-lg">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
            </div>

            <h1 class="font-serif text-3xl md:text-4xl font-extrabold text-mumpul-maroon">
                Pesanan Berhasil! 
            </h1>
            <p class="text-mumpul-text mt-3 text-sm leading-relaxed max-w-xl mx-auto">
                Terima kasih, <strong class="text-mumpul-maroon">{{ $order->customer_name }}</strong>!
                Pesanan kamu dengan kode <strong class="text-mumpul-maroon">{{ $order->order_code }}</strong> sudah kami terima.
                Tim Roti Mumpul akan mengonfirmasi melalui WhatsApp ke nomor <strong class="text-mumpul-maroon">{{ $order->whatsapp_number }}</strong>.
            </p>
        </div>

        <!-- Order Detail -->
        <div class="bg-mumpul-cream border-2 border-mumpul-maroon rounded-3xl p-6 md:p-8 shadow-xl mt-6">
            <h2 class="font-serif font-bold text-xl text-mumpul-maroon border-b border-mumpul-maroon/20 pb-3 mb-4">
                Detail Pesanan
            </h2>

            <ul class="divide-y divide-mumpul-maroon/10 mb-6">
                @foreach($order->orderItems as $item)
                    <li class="py-3 flex items-center gap-4">
                        <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" class="w-14 h-14 object-cover rounded-lg border border-mumpul-maroon/20">
                        <div class="flex-1">
                            <p class="font-serif font-bold text-mumpul-maroon">{{ $item->product->name }}</p>
                            <p class="text-xs text-mumpul-text">{{ $item->quantity }} pcs &times; IDR {{ number_format($item->price, 0, ',', '.') }}</p>
                        </div>
                        <span class="font-bold text-mumpul-maroon text-sm">
                            IDR {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                        </span>
                    </li>
                @endforeach
            </ul>

            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm border-t border-mumpul-maroon/20 pt-4">
                <div>
                    <dt class="text-mumpul-text/70 font-semibold">Metode Pengambilan</dt>
                    <dd class="font-bold text-mumpul-maroon">{{ $order->fulfillment_type === 'delivery' ? 'Delivery' : 'Pick Up' }}</dd>
                </div>
                <div>
                    <dt class="text-mumpul-text/70 font-semibold">Tanggal & Jam</dt>
                    <dd class="font-bold text-mumpul-maroon">{{ \Carbon\Carbon::parse($order->fulfillment_date)->format('d M Y') }}, {{ \Carbon\Carbon::parse($order->fulfillment_time)->format('H:i') }} WIB</dd>
                </div>
                @if($order->fulfillment_type === 'delivery' && $order->address)
                    <div class="sm:col-span-2">
                        <dt class="text-mumpul-text/70 font-semibold">Alamat</dt>
                        <dd class="font-bold text-mumpul-maroon">{{ $order->address }}</dd>
                    </div>
                @endif
                <div>
                    <dt class="text-mumpul-text/70 font-semibold">Metode Pembayaran</dt>
                    <dd class="font-bold text-mumpul-maroon">
                        {{ ['transfer' => 'Transfer Bank', 'qris' => 'QRIS', 'cod' => 'Bayar di Tempat (COD)'][$order->payment_method] ?? $order->payment_method }}
                    </dd>
                </div>
                <div>
                    <dt class="text-mumpul-text/70 font-semibold">Status</dt>
                    <dd><span class="inline-block bg-mumpul-yellow text-mumpul-maroon text-xs font-extrabold px-3 py-1 rounded-full uppercase tracking-wide border border-mumpul-maroon/30">{{ $order->status }}</span></dd>
                </div>
                @if($order->notes)
                    <div class="sm:col-span-2">
                        <dt class="text-mumpul-text/70 font-semibold">Catatan</dt>
                        <dd class="font-bold text-mumpul-maroon">{{ $order->notes }}</dd>
                    </div>
                @endif
            </dl>

            <div class="flex justify-between items-center border-t-2 border-mumpul-maroon/20 mt-6 pt-4">
                <span class="font-serif font-bold text-mumpul-maroon">Total Bayar</span>
                <span class="font-serif font-extrabold text-2xl text-mumpul-maroon">IDR {{ number_format($order->total_amount, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex flex-col sm:flex-row gap-4 mt-6">
            <a href="{{ route('products.index') }}" class="flex-1 text-center bg-mumpul-green hover:bg-mumpul-greenHover text-mumpul-cream font-bold py-3 rounded-xl transition shadow border border-mumpul-cream/20">
                Pesan Lagi
            </a>
            <a href="https://wa.me/{{ config('services.whatsapp.number') }}?text={{ rawurlencode('Halo Roti Mumpul, saya sudah membuat pesanan dengan kode '.$order->order_code.'. Mohon konfirmasinya. Terima kasih.') }}"
               target="_blank" rel="noopener noreferrer"
               class="flex-1 text-center bg-mumpul-yellow hover:bg-yellow-300 text-mumpul-maroon font-bold py-3 rounded-xl transition shadow border border-mumpul-maroon/30">
                Konfirmasi via WhatsApp
            </a>
        </div>
    </div>
</div>
@endsection
