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
        Schema::create('package_tours', function (Blueprint $table) {
            $table->id();
            $table->json('title')->comment('title tour');
            $table->json('sub_desc')->nullable()->comment('sub desc');
            $table->json('desc')->nullable();
            $table->bigInteger('city_id')->nullable()->comment('fk city');
            $table->date('start_date')->default(now())->comment('start date tour');
            $table->date('end_date')->default(now())->comment('end date tour');
            $table->integer('duration')->default(1)->comment('duration tour');
            $table->bigInteger('tour_type_id')->nullable()->comment('fk tour type');
            $table->double('price')->default(0)->comment('price tour');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('package_tours');
    }
};
