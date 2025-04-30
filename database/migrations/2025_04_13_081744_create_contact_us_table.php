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
        Schema::create('contact_us', function (Blueprint $table) {
            $table->id(); // id column
            $table->string('name'); // name column
            $table->string('email'); // email column
            $table->string('phone_number')->nullable(); // phone_number column (optional)
            $table->text('message'); // message column
            $table->enum('status', ['pending', 'responded', 'closed'])->default('pending'); // status column
            $table->timestamps(); // created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_us');
    }
};
