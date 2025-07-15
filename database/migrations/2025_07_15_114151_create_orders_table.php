<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")
            ->constrained()
            ->cascadeOnDelete();
            $table->decimal("total",12,2);
            $table->enum('status', [
        'pending', 'paid', 'shipped', 'completed', 'cancelled'
    ])->default('pending');
    $table->json("shipping_address");//kullanıcı bilgileri isim tel no vs.
    
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
