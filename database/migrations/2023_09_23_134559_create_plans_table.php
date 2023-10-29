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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->json('name')->nullable();
            $table->string('type')->nullable();
            $table->json('description')->nullable();
            $table->json('description_rest')->nullable();
            $table->json('description_onpay')->nullable();
            $table->integer('duration');  /// days
            $table->decimal('cost',8,2);
            $table->decimal('exchange_rate',20,2);
            $table->decimal('monthly_cost',4,2)->nullable();
            $table->boolean('status');  /// days
            $table->integer('priority');  /// days
            $table->datetime('valid_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
