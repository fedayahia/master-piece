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
        Schema::table('bookings', function (Blueprint $table) {
            $table->unsignedBigInteger('available_time_id')->nullable(); 
            
            $table->foreign('available_time_id')->references('id')->on('available_times')->onDelete('set null');
        });
    }
    
    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['available_time_id']);
            $table->dropColumn('available_time_id');
        });
    }
    
    /**
     * Reverse the migrations.
     */

};
