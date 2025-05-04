<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->decimal('discount_amount', 10, 2);
            $table->string('discount_type')->default('percentage');
            $table->unsignedBigInteger('applicable_id');
            $table->string('applicable_type');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps(); 
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
