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
        Schema::create('food', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('cat_id')->references('id')->on('categories')->onDelete('cascade');
            $table->string('img')->nullable();
            $table->integer('price')->nullable();
            $table->integer('old_price')->nullable();
            $table->integer('sorm')->default(0);
            $table->integer('priority')->default(0);
            $table->json('options')->nullable();
            $table->integer('status')->default(1);
            $table->integer('special')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('food');
    }
};
