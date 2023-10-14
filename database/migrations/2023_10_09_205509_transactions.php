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
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('subscription_id')->nullable()->references('id')->on('subscriptions');
            $table->foreignId('plan_id')->nullable()->references('id')->on('plans');
            $table->foreignId('user_id')->nullable()->references('id')->on('users');
            $table->json('transactions_data')->nullable();
            $table->string('result')->nullable();
            $table->json('card_data')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
