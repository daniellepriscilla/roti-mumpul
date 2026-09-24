<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_code')->unique();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('customer_name');
            $table->string('whatsapp_number');
            $table->enum('fulfillment_type', ['pickup', 'delivery']);
            $table->date('fulfillment_date');
            $table->time('fulfillment_time');
            $table->text('address')->nullable();
            $table->text('notes')->nullable();
            $table->decimal('total_amount', 12, 2);
            $table->string('payment_method')->nullable();
            $table->enum('status', ['pending', 'paid', 'completed', 'cancelled'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
