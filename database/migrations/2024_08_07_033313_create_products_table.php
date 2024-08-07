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
            $table->id();
            $table->json('name');
            $table->string('image')->nullable()->comment('path image');
            $table->double('price')->default(0)->comment('price');
            $table->enum('star', [0, 1, 2, 3, 4, 5])->default(0)->comment('review star product');
            $table->double('price_sale')->default(0)->comment('for sale');
            $table->bigInteger('product_type_id')->comment('fk proruct_type');
            $table->enum('status', ['ACTIVE', 'UNACTIVE'])->default('ACTIVE');
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
