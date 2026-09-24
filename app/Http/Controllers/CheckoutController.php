<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function review(Request $request): RedirectResponse
    {
        $cartItems = $this->cartItems();

        if ($cartItems->isEmpty()) {
            return redirect()->route('products.index')->with('error', 'Keranjang belanja kamu masih kosong.');
        }

        if ($this->totalQuantity($cartItems) > CartController::MAX_ITEMS) {
            return redirect()->route('cart.index')->with('error', 'Total pemesanan maksimal 20 pcs. Untuk bulk order silakan hubungi via WhatsApp.');
        }

        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'whatsapp_number' => 'required|string|max:20',
            'fulfillment_type' => ['required', Rule::in(['pickup', 'delivery'])],
            'fulfillment_date' => 'required|date|after_or_equal:today',
            'fulfillment_time' => 'required',
            'address' => 'required_if:fulfillment_type,delivery|nullable|string|max:500',
            'notes' => 'nullable|string|max:1000',
        ]);

        $request->session()->put('checkout', $validated);

        return redirect()->route('checkout.index');
    }

    public function index(Request $request): View|RedirectResponse
    {
        $checkoutData = $request->session()->get('checkout');

        if (! $checkoutData) {
            return redirect()->route('cart.index')->with('error', 'Isi formulir pemesanan terlebih dahulu.');
        }

        $cartItems = $this->cartItems();

        if ($cartItems->isEmpty()) {
            return redirect()->route('products.index')->with('error', 'Keranjang belanja kamu masih kosong.');
        }

        $totalQuantity = $this->totalQuantity($cartItems);
        $totalAmount = $cartItems->sum(fn ($item) => $item->product->price * $item->quantity);

        return view('pages.checkout', compact('cartItems', 'totalQuantity', 'totalAmount', 'checkoutData'));
    }

    public function process(Request $request): RedirectResponse
    {
        $checkoutData = $request->session()->get('checkout');

        if (! $checkoutData) {
            return redirect()->route('cart.index')->with('error', 'Isi formulir pemesanan terlebih dahulu.');
        }

        $cartItems = $this->cartItems();

        if ($cartItems->isEmpty()) {
            return redirect()->route('products.index')->with('error', 'Keranjang belanja kamu masih kosong.');
        }

        if ($this->totalQuantity($cartItems) > CartController::MAX_ITEMS) {
            return redirect()->route('cart.index')->with('error', 'Total pemesanan maksimal 20 pcs. Untuk bulk order silakan hubungi via WhatsApp.');
        }

        $validated = $request->validate([
            'payment_method' => ['required', Rule::in(['transfer', 'qris', 'cod'])],
        ]);

        $totalAmount = $cartItems->sum(fn ($item) => $item->product->price * $item->quantity);

        $order = Order::create([
            'order_code' => 'RM-'.strtoupper(Str::random(6)),
            'user_id' => Auth::id(),
            'customer_name' => $checkoutData['customer_name'],
            'whatsapp_number' => $checkoutData['whatsapp_number'],
            'fulfillment_type' => $checkoutData['fulfillment_type'],
            'fulfillment_date' => $checkoutData['fulfillment_date'],
            'fulfillment_time' => $checkoutData['fulfillment_time'],
            'address' => $checkoutData['fulfillment_type'] === 'delivery' ? ($checkoutData['address'] ?? null) : null,
            'notes' => $checkoutData['notes'] ?? null,
            'total_amount' => $totalAmount,
            'payment_method' => $validated['payment_method'],
            'status' => 'pending',
        ]);

        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
            ]);
        }

        Cart::where('user_id', Auth::id())->delete();
        $request->session()->forget('checkout');

        return redirect()->route('checkout.success', $order->id);
    }

    public function success(Request $request, Order $order): View
    {
        if ($order->user_id !== $request->user()->id) {
            abort(403);
        }

        $order->load('orderItems.product');

        return view('pages.checkout-success', compact('order'));
    }

    private function cartItems()
    {
        return Cart::with('product')->where('user_id', Auth::id())->get();
    }

    private function totalQuantity($cartItems): int
    {
        return (int) $cartItems->sum('quantity');
    }
}
