<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_unauthenticated_checkout_redirects_to_login(): void
    {
        $response = $this->get('/checkout');

        $response->assertRedirect(route('login'));
    }

    public function test_review_stores_order_form_in_session_and_redirects_to_checkout(): void
    {
        $user = User::factory()->create();
        Cart::factory()->for($user)->create(['quantity' => 2]);

        $response = $this->actingAs($user)->post(route('checkout.review'), $this->validReviewPayload());

        $response->assertRedirect(route('checkout.index'));
        $response->assertSessionHas('checkout');
    }

    public function test_review_requires_address_when_delivery_is_selected(): void
    {
        $user = User::factory()->create();
        Cart::factory()->for($user)->create();

        $response = $this->actingAs($user)->post(route('checkout.review'), [
            ...$this->validReviewPayload(),
            'fulfillment_type' => 'delivery',
            'address' => null,
        ]);

        $response->assertSessionHasErrors('address');
        $response->assertSessionMissing('checkout');
    }

    public function test_review_rejects_order_form_when_cart_is_empty(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('checkout.review'), $this->validReviewPayload());

        $response->assertRedirect(route('products.index'));
        $response->assertSessionHas('error');
        $response->assertSessionMissing('checkout');
    }

    public function test_checkout_page_redirects_to_cart_when_review_is_skipped(): void
    {
        $user = User::factory()->create();
        Cart::factory()->for($user)->create();

        $response = $this->actingAs($user)->get(route('checkout.index'));

        $response->assertRedirect(route('cart.index'));
        $response->assertSessionHas('error');
    }

    public function test_checkout_page_renders_order_summary_after_review(): void
    {
        $user = User::factory()->create();
        Cart::factory()->for($user)->create(['quantity' => 3]);
        $payload = $this->validReviewPayload();

        $response = $this->actingAs($user)
            ->withSession(['checkout' => $payload])
            ->get(route('checkout.index'));

        $response->assertOk();
        $response->assertSee($payload['customer_name']);
        $response->assertSee('Metode Pembayaran');
    }

    public function test_process_creates_order_and_clears_cart(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create(['price' => 25000]);
        Cart::factory()->for($user)->create([
            'product_id' => $product->id,
            'quantity' => 2,
        ]);
        $payload = $this->validReviewPayload();

        $response = $this->actingAs($user)
            ->withSession(['checkout' => $payload])
            ->post(route('checkout.process'), ['payment_method' => 'transfer']);

        $order = Order::sole();
        $response->assertRedirect(route('checkout.success', $order));
        $response->assertSessionMissing('checkout');

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'user_id' => $user->id,
            'customer_name' => $payload['customer_name'],
            'whatsapp_number' => $payload['whatsapp_number'],
            'fulfillment_type' => 'pickup',
            'payment_method' => 'transfer',
            'status' => 'pending',
            'total_amount' => 50000,
            'address' => null,
        ]);
        $this->assertDatabaseHas('order_items', [
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 2,
            'price' => 25000,
        ]);
        $this->assertDatabaseCount('carts', 0);
    }

    public function test_process_requires_a_valid_payment_method(): void
    {
        $user = User::factory()->create();
        Cart::factory()->for($user)->create();

        $response = $this->actingAs($user)
            ->withSession(['checkout' => $this->validReviewPayload()])
            ->post(route('checkout.process'), ['payment_method' => 'crypto']);

        $response->assertSessionHasErrors('payment_method');
        $this->assertDatabaseCount('orders', 0);
        $this->assertDatabaseCount('carts', 1);
    }

    public function test_process_redirects_to_cart_when_review_is_skipped(): void
    {
        $user = User::factory()->create();
        Cart::factory()->for($user)->create();

        $response = $this->actingAs($user)
            ->post(route('checkout.process'), ['payment_method' => 'transfer']);

        $response->assertRedirect(route('cart.index'));
        $response->assertSessionHas('error');
        $this->assertDatabaseCount('orders', 0);
    }

    public function test_success_renders_own_order(): void
    {
        $user = User::factory()->create();
        $order = Order::create($this->orderAttributes($user));

        $response = $this->actingAs($user)->get(route('checkout.success', $order));

        $response->assertOk();
        $response->assertSee($order->order_code);
    }

    public function test_success_forbids_viewing_another_users_order(): void
    {
        $owner = User::factory()->create();
        $intruder = User::factory()->create();
        $order = Order::create($this->orderAttributes($owner));

        $response = $this->actingAs($intruder)->get(route('checkout.success', $order));

        $response->assertForbidden();
    }

    private function validReviewPayload(): array
    {
        return [
            'customer_name' => 'Budi Santoso',
            'whatsapp_number' => '081234567890',
            'fulfillment_type' => 'pickup',
            'fulfillment_date' => now()->addDay()->toDateString(),
            'fulfillment_time' => '07:30',
            'address' => null,
            'notes' => 'Tanpa lilin',
        ];
    }

    private function orderAttributes(User $user): array
    {
        return [
            'order_code' => 'RM-TEST01',
            'user_id' => $user->id,
            'customer_name' => 'Budi Santoso',
            'whatsapp_number' => '081234567890',
            'fulfillment_type' => 'pickup',
            'fulfillment_date' => now()->addDay()->toDateString(),
            'fulfillment_time' => '07:30',
            'address' => null,
            'notes' => null,
            'total_amount' => 50000,
            'payment_method' => 'transfer',
            'status' => 'pending',
        ];
    }
}
