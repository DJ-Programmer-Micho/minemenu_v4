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
        Schema::create('food_translators', function (Blueprint $table) {
            $table->id();
            $table->foreignId('food_id')->references('id')->on('food')->onDelete('cascade')->onUpdate('cascade');
            $table->string('locale',5);
            $table->string('name')->nullable();
            $table->string('description',1000)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('food_translators');
    }
};
