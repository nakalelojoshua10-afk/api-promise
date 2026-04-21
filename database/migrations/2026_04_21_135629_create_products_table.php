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
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            // Relasi ke tabel stores
            // Menggunakan foreignUuid otomatis membuat kolom 'store_id' dan foreign key-nya
            $table->foreignUuid('store_id')
                  ->constrained('stores')
                  ->onDelete('cascade');

            // Relasi ke tabel product_categories
            // PERBAIKAN: Pastikan nama tabel referensinya sesuai (biasanya jamak: product_categories)
            $table->foreignUuid('product_category_id')
                  ->constrained('product_categories') 
                  ->onDelete('cascade');

            $table->string('name');
            $table->string('slug')->unique();
            $table->longText('description');
            $table->enum('condition', ['new', 'second']);
            $table->decimal('price', 26, 2);
            $table->integer('weight');
            $table->integer('stock');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};