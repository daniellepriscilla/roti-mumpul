@php
    $waNumber = config('services.whatsapp.number');
    $waBulkLink = 'https://wa.me/'.$waNumber.'?text='.rawurlencode('Halo Roti Mumpul, saya ingin melakukan bulk order (pesan dalam jumlah banyak). Mohon informasinya. Terima kasih.');
@endphp

<nav x-data="{ open: false }" class="sticky top-0 z-40 bg-mumpul-maroon border-b border-mumpul-green/30 text-mumpul-cream shadow-md">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center space-x-8">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="shrink-0 flex items-center gap-2 font-serif text-xl sm:text-2xl font-bold tracking-wide text-mumpul-yellow">
                    <img src="{{ asset('images/logo-roti-mumpul.svg') }}" alt="Logo Roti Mumpul" class="w-9 h-9 rounded-full border border-mumpul-yellow/60 bg-mumpul-cream">
                    <span>Roti Mumpul</span>
                </a>

                <!-- Navigation Links -->
                <div class="hidden space-x-6 sm:-my-px sm:flex">
                    <a href="{{ route('home') }}" class="inline-flex items-center px-1 pt-1 text-sm font-semibold text-mumpul-cream hover:text-mumpul-yellow transition">
                        Home
                    </a>
                    <a href="{{ route('products.index') }}" class="inline-flex items-center px-1 pt-1 text-sm font-semibold text-mumpul-cream hover:text-mumpul-yellow transition">
                        Products
                    </a>
                    <a href="{{ route('events') }}" class="inline-flex items-center px-1 pt-1 text-sm font-semibold text-mumpul-cream hover:text-mumpul-yellow transition">
                        Events
                    </a>
                </div>
            </div>

            <!-- Header Right Menu -->
            <div class="hidden sm:flex sm:items-center sm:ms-6 space-x-3">
                <a href="{{ $waBulkLink }}" target="_blank" rel="noopener noreferrer" class="bg-mumpul-yellow hover:bg-yellow-300 text-mumpul-maroon px-3 py-2 rounded-xl text-xs font-bold shadow-sm transition border border-mumpul-cream/30 whitespace-nowrap">
                    Bulk Order
                </a>

                @auth
                    <a href="{{ route('cart.index') }}" class="relative bg-mumpul-green hover:bg-mumpul-greenHover text-mumpul-cream px-4 py-2 rounded-xl text-sm font-bold shadow-sm transition border border-mumpul-cream/20">
                        Keranjang
                        @if($cartCount > 0)
                            <span class="absolute -top-2 -right-2 bg-mumpul-yellow text-mumpul-maroon text-[10px] font-extrabold rounded-full min-w-[20px] h-5 px-1 flex items-center justify-center border border-mumpul-maroon">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm font-medium text-mumpul-cream/80 hover:text-mumpul-cream">
                            Log Out
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-bold text-mumpul-cream hover:text-mumpul-yellow">Login</a>
                    <a href="{{ route('register') }}" class="bg-mumpul-green hover:bg-mumpul-greenHover text-mumpul-cream font-bold px-4 py-2 rounded-xl text-sm transition shadow border border-mumpul-cream/20">
                        Sign In
                    </a>
                @endauth
            </div>

            <!-- Mobile Menu Toggle -->
            <div class="flex items-center sm:hidden">
                <button @click="open = !open" type="button" class="inline-flex items-center justify-center p-2 rounded-xl text-mumpul-cream hover:text-mumpul-yellow hover:bg-mumpul-maroon/60 focus:outline-none" aria-label="Buka menu">
                    <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    <svg x-show="open" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu Panel -->
    <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="sm:hidden border-t border-mumpul-cream/10 bg-mumpul-maroon">
        <div class="pt-2 pb-4 space-y-1 px-4">
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-xl text-base font-semibold text-mumpul-cream hover:text-mumpul-yellow hover:bg-mumpul-maroon/60">Home</a>
            <a href="{{ route('products.index') }}" class="block px-3 py-2 rounded-xl text-base font-semibold text-mumpul-cream hover:text-mumpul-yellow hover:bg-mumpul-maroon/60">Products</a>
            <a href="{{ route('events') }}" class="block px-3 py-2 rounded-xl text-base font-semibold text-mumpul-cream hover:text-mumpul-yellow hover:bg-mumpul-maroon/60">Events</a>
            <a href="{{ $waBulkLink }}" target="_blank" rel="noopener noreferrer" class="block px-3 py-2 rounded-xl text-base font-semibold text-mumpul-yellow hover:bg-mumpul-maroon/60">Bulk Order</a>

            @auth
                <a href="{{ route('cart.index') }}" class="block px-3 py-2 rounded-xl text-base font-semibold text-mumpul-cream hover:text-mumpul-yellow hover:bg-mumpul-maroon/60">
                    Keranjang @if($cartCount > 0)&mdash; {{ $cartCount }} item @endif
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-3 py-2 rounded-xl text-base font-semibold text-mumpul-cream/80 hover:text-mumpul-cream hover:bg-mumpul-maroon/60">
                        Log Out
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="block px-3 py-2 rounded-xl text-base font-semibold text-mumpul-cream hover:text-mumpul-yellow hover:bg-mumpul-maroon/60">Login</a>
                <a href="{{ route('register') }}" class="block px-3 py-2 rounded-xl text-base font-semibold text-mumpul-cream hover:text-mumpul-yellow hover:bg-mumpul-maroon/60">Sign In</a>
            @endauth
        </div>
    </div>
</nav>
