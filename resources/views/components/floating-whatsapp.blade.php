@php
    $waNumber = config('services.whatsapp.number');
    $waLink = 'https://wa.me/'.$waNumber.'?text='.rawurlencode('Halo Roti Mumpul! Saya ingin bertanya-tanya mengenai toko dan produk, atau melakukan bulk order. Terima kasih.');
@endphp

<a href="{{ $waLink }}"
   target="_blank"
   rel="noopener noreferrer"
   title="Chat WhatsApp - Bulk Order & Pertanyaan"
   class="fixed bottom-5 right-5 z-50 inline-flex items-center gap-2 bg-[#25D366] hover:bg-[#1EBE5A] text-white font-bold px-4 py-3 rounded-full shadow-2xl transition transform hover:scale-105 border-2 border-white/80">
    <svg class="w-6 h-6" viewBox="0 0 32 32" fill="currentColor" aria-hidden="true">
        <path d="M16.004 3C9.383 3 4 8.383 4 15.004c0 2.114.55 4.176 1.594 5.996L4 29l8.23-1.55A11.94 11.94 0 0 0 16.004 27C22.625 27 28 21.617 28 14.996S22.625 3 16.004 3zm0 21.82a9.8 9.8 0 0 1-5.01-1.37l-.36-.21-4.886.925.94-4.77-.235-.375A9.79 9.79 0 0 1 6.18 15c0-5.42 4.41-9.825 9.824-9.825 5.415 0 9.82 4.406 9.82 9.825 0 5.414-4.405 9.82-9.82 9.82zm5.39-7.355c-.295-.15-1.745-.86-2.016-.957-.27-.1-.467-.15-.664.15-.197.295-.761.956-.933 1.153-.172.197-.344.22-.639.075-.295-.15-1.245-.46-2.37-1.466-.877-.784-1.47-1.753-1.642-2.048-.172-.295-.018-.454.13-.602.134-.133.295-.345.443-.517.148-.172.197-.296.296-.493.098-.198.05-.371-.025-.52-.075-.148-.664-1.6-.91-2.19-.24-.574-.484-.497-.664-.505l-.565-.01c-.197 0-.517.074-.788.37-.27.296-1.034 1.01-1.034 2.465s1.06 2.856 1.207 3.054c.148.197 2.086 3.187 5.054 4.47.707.306 1.258.489 1.688.626.71.225 1.356.193 1.868.117.571-.085 1.745-.713 1.99-1.402.247-.688.247-1.278.173-1.402-.074-.124-.27-.198-.565-.347z"/>
    </svg>
    <span class="hidden sm:inline text-sm">Chat & Bulk Order</span>
</a>
