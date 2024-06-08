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
        Schema::create('rest_ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedTinyInteger('staff')->default(0);
            $table->unsignedTinyInteger('service')->default(0);
            $table->unsignedTinyInteger('environment')->default(0);
            $table->unsignedTinyInteger('experience')->default(0);
            $table->unsignedTinyInteger('cleaning')->default(0);
            $table->text('note')->nullable();
            $table->timestamps();

            $table->unique(['customer_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rest_ratings');
    }
};
