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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->unique('user_id');
            $table->string('default_lang');
            $table->json('languages');
            $table->string('phone');
            $table->string('wifi');
            $table->string('facebook');
            $table->string('instagram');
            $table->string('website');
            $table->string('telegram');
            $table->string('snapchat');
            $table->string('note');
            $table->string('map');
            $table->string('tiktok');
            $table->string('background_img');
            $table->string('background_vid');
            $table->string('intro_page');
            $table->string('currency');
            $table->string('fees');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
