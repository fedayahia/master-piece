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
        Schema::create('events', function (Blueprint $table) {
            $table->id();  // ID الأساسي
            $table->string('title');  // اسم الحدث
            $table->text('description')->nullable();  // وصف الحدث
            $table->date('event_date');  // تاريخ الحدث
            $table->time('start_time');  // وقت البداية
            $table->time('end_time');  // وقت النهاية
            $table->string('location'); 
            $table->string('image')->nullable();
            $table->string('instructor')->nullable();  // اسم المدرب (اختياري)
            $table->boolean('is_free')->default(true); 
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
