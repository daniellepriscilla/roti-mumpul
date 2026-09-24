@php
    $waNumber = config('services.whatsapp.number');
    $waBulkLink = 'https://wa.me/'.$waNumber.'?text='.rawurlencode('Halo Roti Mumpul, saya ingin melakukan bulk order (pesan dalam jumlah banyak). Mohon informasinya. Terima kasih.');
@endphp

<footer class="bg-mumpul-maroon text-mumpul-cream border-t-4 border-mumpul-yellow">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            <!-- Brand -->
            <div class="space-y-4">
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <img src="{{ asset('images/logo-roti-mumpul.svg') }}" alt="Logo Roti Mumpul" class="w-12 h-12 rounded-full border border-mumpul-yellow/60 bg-mumpul-cream">
                    <span class="font-serif text-2xl font-bold text-mumpul-yellow">Roti Mumpul</span>
                </a>
                <p class="text-mumpul-cream/80 text-sm leading-relaxed">
                    Roti pulen, rasa jadul. Dibuat fresh setiap pagi dengan resep tradisional dan bahan-bahan pilihan.
                </p>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="font-serif font-bold text-mumpul-yellow mb-4">Navigasi</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('home') }}" class="text-mumpul-cream/80 hover:text-mumpul-yellow transition">Home</a></li>
                    <li><a href="{{ route('products.index') }}" class="text-mumpul-cream/80 hover:text-mumpul-yellow transition">Products</a></li>
                    <li><a href="{{ route('events') }}" class="text-mumpul-cream/80 hover:text-mumpul-yellow transition">Events</a></li>
                    <li><a href="{{ route('login') }}" class="text-mumpul-cream/80 hover:text-mumpul-yellow transition">Login / Sign In</a></li>
                </ul>
            </div>

            <!-- Bulk Order & Contact -->
            <div>
                <h3 class="font-serif font-bold text-mumpul-yellow mb-4">Pesan Banyak?</h3>
                <p class="text-mumpul-cream/80 text-sm mb-4 leading-relaxed">
                    Pesanan di atas 20 pcs diproses lewat WhatsApp. Klik tombol di bawah untuk bulk order atau bertanya lebih lanjut.
                </p>
                <a href="{{ $waBulkLink }}" target="_blank" rel="noopener noreferrer" class="inline-block bg-mumpul-yellow hover:bg-yellow-300 text-mumpul-maroon font-bold px-5 py-3 rounded-xl text-sm shadow border border-mumpul-cream/30 transition">
                    Bulk Order via WhatsApp
                </a>
                <p class="text-mumpul-cream/60 text-xs mt-4">
                    CFD Tunjungan Surabaya &middot; Setiap Minggu pagi, 06.00 WIB - selesai
                </p>
            </div>
        </div>

        <div class="border-t border-mumpul-cream/20 mt-10 pt-6 text-center text-xs text-mumpul-cream/60">
            &copy; {{ date('Y') }} Roti Mumpul. Semua hak dilindungi.
        </div>
    </div>
</footer>
