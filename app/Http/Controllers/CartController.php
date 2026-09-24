<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CartController extends Controller
{
    public const MAX_ITEMS = 20;

    public function index(): View
    {
        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        $totalQuantity = $cartItems->sum('quantity');
        $totalAmount = $cartItems->sum(fn ($item) => $item->product->price * $item->quantity);

        return view('pages.cart', compact('cartItems', 'totalQuantity', 'totalAmount'));
    }

    public function add(Request $request, Product $product): RedirectResponse
    {
        $userId = Auth::id();
        $currentCartTotal = Cart::where('user_id', $userId)->sum('quantity');

        if ($currentCartTotal + 1 > self::MAX_ITEMS) {
            return redirect()->route('cart.index')->with('error', 'Jumlah produk di keranjang melebihi batas 20 pcs. Silakan gunakan fitur Bulk Order via WhatsApp untuk pemesanan jumlah besar.');
        }

        $cartItem = Cart::where('user_id', $userId)
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            $cartItem->increment('quantity');
        } else {
            Cart::create([
                'user_id' => $userId,
                'product_id' => $product->id,
                'quantity' => 1,
            ]);
        }

        return redirect()->route('cart.index')->with('success', $product->name.' berhasil ditambahkan ke keranjang!');
    }

    public function update(Request $request, Cart $cart): RedirectResponse
    {
        if ($cart->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $userId = Auth::id();
        $otherCartTotal = Cart::where('user_id', $userId)
            ->where('id', '!=', $cart->id)
            ->sum('quantity');

        $newTotal = $otherCartTotal + $request->quantity;

        if ($newTotal > self::MAX_ITEMS) {
            return redirect()->back()->with('error', 'Total item tidak boleh melebihi 20 pcs. Gunakan Bulk Order WhatsApp untuk pesanan di atas 20 pcs.');
        }

        $cart->update(['quantity' => $request->quantity]);

        return redirect()->back()->with('success', 'Jumlah pesanan berhasil diperbarui!');
    }

    public function destroy(Cart $cart): RedirectResponse
    {
        if ($cart->user_id !== Auth::id()) {
            abort(403);
        }

        $cart->delete();

        return redirect()->back()->with('success', 'Produk dihapus dari keranjang.');
    }
}
