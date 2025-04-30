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
        Schema::create('available_times', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('private_session_id');
            $table->timestamp('available_date');
            $table->boolean('is_available')->default(true);
            $table->timestamps();
            
            $table->foreign('private_session_id')
                  ->references('id')
                  ->on('private_sessions')
                  ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('available_times');
    }
};
