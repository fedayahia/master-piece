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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->timestamp('booking_date')->useCurrent();
            $table->string('seat_number')->nullable();
    
            $table->enum('status', ['enrolled', 'not_enrolled'])->default('not_enrolled');
    
            $table->foreignId('user_id')
                  ->constrained('users')  
                  ->onDelete('cascade');
    
            $table->morphs('booking_for'); 
    
            $table->timestamps();
    
            $table->index('status');
            $table->index('booking_date');
    
            $table->unique(['user_id', 'booking_for_id', 'booking_for_type']);
        });
     
    }        

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking');
    }
};
