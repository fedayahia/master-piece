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
        Schema::create('sessions', function (Blueprint $table) {
            $table->id(); // عمود id سيكون المفتاح الأساسي
            $table->string('session_name'); // اسم الجلسة
            $table->timestamp('start_time')->useCurrent();  // استخدم الوقت الحالي كقيمة افتراضية
            $table->timestamp('end_time')->nullable(); // وقت نهاية الجلسة
            $table->timestamps(); // لتخزين وقت الإنشاء والتعديل
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
    }
};
