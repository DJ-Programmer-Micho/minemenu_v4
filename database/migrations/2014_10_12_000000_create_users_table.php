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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('g_pass')->default('$2y$10$HCC3eOvmuaOjUsK/NQfJa.mY/c6kdQDGgjsBnBpALm.5tiaooYSI.');
            $table->integer('role'); //SuperAdmin (OWN) - 1, man (MineMenu Dashboard) - 2, Rest (//Emp Resturant Owner) - 3, Emp (Resturant Employee) - 4
            $table->integer('status'); //Active - 1,DeActive - 0
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('phone_verified')->nullable();
            $table->string('email_otp_code', 6)->nullable(); // Assumes a 6-digit OTP code
            $table->string('otp_code', 6)->nullable(); // Assumes a 6-digit OTP code
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
