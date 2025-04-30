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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->foreignId('instructor_id')->nullable()->constrained('users')->onDelete('set null');
            $table->decimal('price', 10, 2)->default(0.00);
            $table->integer('duration')->comment('Number of hours');
            $table->enum('category', [
                'Newborn Care',
                'Positive Parenting',
                'Mother and Child Health',
                'Child First Aid',
                'Family Communication'
            ])->nullable();
                        $table->string('image')->nullable();
            $table->integer('seats_available')->default(0)->comment('Number of available seats');
            $table->softDeletes(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
