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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->json('title')->nullable();
            $table->json('desc')->nullable();
            $table->string('by')->nullable()->comment('review by');
            $table->dateTime('date')->default(now())->comment('review date');
            $table->enum('star', [0, 1, 2, 3, 4, 5])->default(0)->comment('review star');
            $table->string('image')->nullable();
            $table->enum('status', ['ACTIVE', 'UNACTIVE'])->default('ACTIVE');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
