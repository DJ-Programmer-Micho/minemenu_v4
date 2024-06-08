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
        Schema::create('food_ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreignId('food_id')->references('id')->on('food')->onDelete('cascade');
            $table->unsignedTinyInteger('rating')->default(0); // Rating from 0 to 5
            $table->timestamps();

            $table->unique(['customer_id', 'food_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('food_ratings');
    }
};
