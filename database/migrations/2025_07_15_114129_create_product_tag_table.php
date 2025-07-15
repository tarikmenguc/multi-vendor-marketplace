<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('product_tag', function (Blueprint $table) {
            // pivot tabloda oto id olamaz 
            $table->foreignId('product_id')
                  ->constrained() // varsayılan => products.id
                  ->cascadeOnDelete();

            $table->foreignId('tag_id')
                  ->constrained()// varsayılan => tags.id
                  ->cascadeOnDelete();

            // Çift satır oluşmasını engelle
            $table->primary(['product_id', 'tag_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_tag');
    }
};