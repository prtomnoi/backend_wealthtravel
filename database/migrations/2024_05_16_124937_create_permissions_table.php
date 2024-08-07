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
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('role_id')->comment('fk role คนที่มีสิท');
            $table->string('group')->comment('หมวดหมู่สิทธิ์');
            $table->string('table_name')->comment('ชื่อตารางสิทธิ์');
            $table->tinyInteger('create')->default(0)->comment('มีสิทธิ์ใช้งานหรือไม่ 0 คือไม่มี 1 คือ มี');
            $table->tinyInteger('update')->default(0)->comment('มีสิทธิ์ใช้งานหรือไม่ 0 คือไม่มี 1 คือ มี');
            $table->tinyInteger('delete')->default(0)->comment('มีสิทธิ์ใช้งานหรือไม่ 0 คือไม่มี 1 คือ มี');
            $table->tinyInteger('view')->default(0)->comment('มีสิทธิ์ใช้งานหรือไม่ 0 คือไม่มี 1 คือ มี');
            $table->tinyInteger('status')->default(0)->comment('มีสิทธิ์ใช้งานหรือไม่ 0 คือไม่มี 1 คือ มี');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};
