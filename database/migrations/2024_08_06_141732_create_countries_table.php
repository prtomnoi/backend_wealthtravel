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
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('alpha_2')->nullable()->comment('code 2');
            $table->string('alpha_3')->nullable()->comment('code 3');
            $table->string('country_code')->nullable();
            $table->string('iso')->nullable();
            $table->string('region')->nullable();
            $table->string('sub_region')->nullable();
            $table->string('intermediate_region')->nullable();
            $table->string('region_code')->nullable();
            $table->string('sub_region_code')->nullable();
            $table->string('intermediate_region_code')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
