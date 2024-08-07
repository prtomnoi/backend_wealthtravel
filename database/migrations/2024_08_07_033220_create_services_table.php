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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->json('title');
            $table->json('sub_desc')->nullable()->comment('preview service');
            $table->json('desc')->nullable()->comment('description');
            $table->string('image')->nullable()->comment('path image');
            $table->dateTime('date')->default(now());
            $table->bigInteger('service_type_id')->comment('fk serviceType');
            $table->enum('status', ['ACTIVE', 'UNACTIVE'])->default('ACTIVE');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
