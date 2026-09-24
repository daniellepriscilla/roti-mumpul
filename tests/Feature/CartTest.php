<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    public function test_unauthenticated_add_to_cart_redirects_to_login(): void
    {
        $product = Product::factory()->create();

        $response = $this->post(route('cart.add', $product));

        $response->assertRedirect(route('login'));
        $this->assertGuest();
        $this->assertDatabaseCount('carts', 0);
    }

    public function test_cart_page_renders_items_and_order_form(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create(['name' => 'Buttercream', 'price' => 28000]);
        Cart::factory()->for($user)->create([
            'product_id' => $product->id,
            'quantity' => 2,
        ]);

        $response = $this->actingAs($user)->get(route('cart.index'));

        $response->assertOk();
        $response->assertSee('Buttercream');
        $response->assertSee('Formulir Pemesanan');
        $response->assertSee('56.000');
    }

    public function test_authenticated_user_can_add_product_to_cart(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $response = $this->actingAs($user)->post(route('cart.add', $product));

        $response->assertRedirect(route('cart.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('carts', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 1,
        ]);
    }

    public function test_add_increments_quantity_for_product_already_in_cart(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
        Cart::factory()->for($user)->create([
            'product_id' => $product->id,
            'quantity' => 2,
        ]);

        $response = $this->actingAs($user)->post(route('cart.add', $product));

        $response->assertRedirect(route('cart.index'));
        $this->assertDatabaseHas('carts', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 3,
        ]);
    }

    public function test_add_rejects_when_cart_reaches_twenty_items(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
        Cart::factory()->for($user)->create([
            'product_id' => $product->id,
            'quantity' => 20,
        ]);

        $response = $this->actingAs($user)->post(route('cart.add', $product));

        $response->assertRedirect(route('cart.index'));
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('carts', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 20,
        ]);
    }

    public function test_update_persists_new_quantity(): void
    {
        $user = User::factory()->create();
        $cart = Cart::factory()->for($user)->create(['quantity' => 1]);

        $response = $this->actingAs($user)
            ->from(route('cart.index'))
            ->patch(route('cart.update', $cart), ['quantity' => 5]);

        $response->assertRedirect(route('cart.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('carts', [
            'id' => $cart->id,
            'quantity' => 5,
        ]);
    }

    public function test_update_rejects_total_quantity_above_twenty_items(): void
    {
        $user = User::factory()->create();
        $cart = Cart::factory()->for($user)->create(['quantity' => 2]);
        Cart::factory()->for($user)->create(['quantity' => 19]);

        $response = $this->actingAs($user)
            ->from(route('cart.index'))
            ->patch(route('cart.update', $cart), ['quantity' => 5]);

        $response->assertRedirect(route('cart.index'));
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('carts', [
            'id' => $cart->id,
            'quantity' => 2,
        ]);
    }

    public function test_destroy_removes_cart_item(): void
    {
        $user = User::factory()->create();
        $cart = Cart::factory()->for($user)->create();

        $response = $this->actingAs($user)
            ->from(route('cart.index'))
            ->delete(route('cart.remove', $cart));

        $response->assertRedirect(route('cart.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('carts', ['id' => $cart->id]);
    }

    public function test_update_forbids_access_to_another_users_cart(): void
    {
        $owner = User::factory()->create();
        $intruder = User::factory()->create();
        $cart = Cart::factory()->for($owner)->create(['quantity' => 1]);

        $response = $this->actingAs($intruder)
            ->patch(route('cart.update', $cart), ['quantity' => 9]);

        $response->assertForbidden();
        $this->assertDatabaseHas('carts', [
            'id' => $cart->id,
            'quantity' => 1,
        ]);
    }

    public function test_destroy_forbids_access_to_another_users_cart(): void
    {
        $owner = User::factory()->create();
        $intruder = User::factory()->create();
        $cart = Cart::factory()->for($owner)->create();

        $response = $this->actingAs($intruder)->delete(route('cart.remove', $cart));

        $response->assertForbidden();
        $this->assertModelExists($cart);
    }
}
