@extends('layouts.app')

@section('title', 'Events CFD Tunjungan - Roti Mumpul')

@section('content')
<div class="bg-mumpul-cream/30 min-h-screen py-12" x-data="{ openFaq: 0 }">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Main Event Card -->
        <div class="bg-mumpul-cream border-2 border-mumpul-maroon rounded-3xl overflow-hidden shadow-2xl">
            <!-- Banner Header -->
            <div class="bg-mumpul-maroon text-mumpul-cream p-8 md:p-12 border-b-4 border-mumpul-yellow text-center relative">
                <h1 class="font-serif text-3xl md:text-5xl font-extrabold leading-tight">
                    CFD Tunjungan Surabaya
                </h1>
                <p class="text-mumpul-cream/90 mt-3 max-w-2xl mx-auto text-base">
                    Nikmati kelembutan Roti Mumpul langsung di Jalan Tunjungan!
                </p>
            </div>

            <!-- Content Detail Event -->
            <div class="p-6 md:p-10 space-y-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white p-5 rounded-2xl border border-mumpul-maroon/20 shadow-sm text-center">
                        <h4 class="font-serif font-bold text-mumpul-maroon">Jadwal</h4>
                        <p class="text-sm text-mumpul-text mt-1">Setiap Hari Minggu Pagi</p>
                    </div>
                    <div class="bg-white p-5 rounded-2xl border border-mumpul-maroon/20 shadow-sm text-center">
                        <h4 class="font-serif font-bold text-mumpul-maroon">Jam Operasional</h4>
                        <p class="text-sm text-mumpul-text mt-1">06.00 WIB - Selesai (Habis)</p>
                    </div>
                    <div class="bg-white p-5 rounded-2xl border border-mumpul-maroon/20 shadow-sm text-center">
                        <h4 class="font-serif font-bold text-mumpul-maroon">Lokasi Booth</h4>
                        <p class="text-sm text-mumpul-text mt-1">Jl. Tunjungan, Surabaya</p>
                    </div>
                </div>

                <!-- Petunjuk Pemesanan Pick Up CFD -->
                <div class="bg-mumpul-yellow/20 border-2 border-dashed border-mumpul-maroon/40 rounded-2xl p-6 md:p-8">
                    <h3 class="font-serif font-bold text-2xl text-mumpul-maroon mb-3 flex items-center gap-2">
                        Layanan Pre-Order & Pick Up CFD
                    </h3>
                    <p class="text-mumpul-text text-sm leading-relaxed mb-4">
                        Ingin memastikan varian roti favoritmu tidak kehabisan saat CFD?
                        <br>Kamu bisa melakukan pemesanan terlebih dahulu melalui website ini dan memilih opsi <strong class="text-mumpul-maroon">Pick Up</strong> saat checkout, lengkap dengan tanggal dan jam pengambilannya.
                    </p>
                    <a href="{{ route('products.index') }}" class="inline-block bg-mumpul-green hover:bg-mumpul-greenHover text-mumpul-cream font-bold px-6 py-3 rounded-xl transition text-sm shadow border border-mumpul-cream/20">
                        Pesan Sekarang untuk CFD &rarr;
                    </a>
                </div>
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="mt-12 bg-mumpul-cream border-2 border-mumpul-maroon rounded-3xl overflow-hidden shadow-2xl">
            <div class="bg-mumpul-maroon text-mumpul-cream p-6 md:p-8 border-b-4 border-mumpul-yellow text-center">
                <h2 class="font-serif text-2xl md:text-3xl font-extrabold">
                    FAQ (Frequently Asked Questions)
                </h2>
            </div>

            <div class="p-4 md:p-6 divide-y divide-mumpul-maroon/10">
                @php
                    $faqs = [
                        ['q' => 'Apa itu Roti Mumpul?', 'a' => 'Roti Mumpul adalah toko roti dengan resep otentik yang mengutamakan tekstur empuk (mumpul), dibuat fresh setiap hari tanpa pengawet.'],
                        ['q' => 'Apakah bisa pesan H-1 lalu diambil saat CFD?', 'a' => 'Bisa. Pre-order maksimal H-1(Sabtu) untuk diambil saat CFD.'],
                        ['q' => 'Jam operasional delivery dan penerimaan pesanan?', 'a' => 'Pukul 10.00 - 22.00 WIB.'],
                        ['q' => 'Apa saja metode pengambilan yang tersedia?', 'a' => 'Tersedia dua metode: Pick Up (ambil langsung di booth/toko) dan Delivery (dikirim via kurir ke alamat kamu). Pilih metode, tanggal, dan jam saat mengisi formulir pemesanan di halaman keranjang.'],
                        ['q' => 'Bagaimana cara metode pembayarannya?', 'a' => 'Setelah mengisi formulir pemesanan, kamu akan masuk ke halaman checkout untuk memilih metode pembayaran: Transfer Bank, QRIS, atau Bayar di Tempat (COD). Instruksi pembayaran akan dikonfirmasi via WhatsApp.'],
                        ['q' => 'Apakah pesanan harus login terlebih dahulu?', 'a' => 'Ya. Login/Sign In diperlukan agar pesanan dan keranjang belanja kamu bisa tersimpan dan diproses. Kamu hanya perlu login satu kali untuk berbelanja.'],
                    ];
                @endphp

                @foreach($faqs as $index => $faq)
                    <div class="py-2">
                        <button type="button"
                                @click="openFaq = openFaq === {{ $index }} ? -1 : {{ $index }}"
                                class="w-full flex items-center justify-between gap-4 text-left py-3 px-2 rounded-xl hover:bg-mumpul-yellow/20 transition">
                            <span class="font-serif font-bold text-mumpul-maroon text-sm md:text-base">{{ $faq['q'] }}</span>
                            <svg class="w-5 h-5 shrink-0 text-mumpul-maroon transition-transform duration-200"
                                 :class="openFaq === {{ $index }} ? 'rotate-180' : ''"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <div x-show="openFaq === {{ $index }}"
                             x-cloak
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 -translate-y-1"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100"
                             x-transition:leave-end="opacity-0"
                             class="px-2 pb-4">
                            <p class="text-mumpul-text text-sm leading-relaxed">{{ $faq['a'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</div>
@endsection
