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
            $table->string('languages');
            $table->string('phone')->nullable();
            $table->string('wifi')->nullable();
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('website')->nullable();
            $table->string('telegram')->nullable();
            $table->string('snapchat')->nullable();
            $table->json('note')->nullable();
            $table->string('map')->nullable();
            $table->string('tiktok')->nullable();
            $table->string('telegram_notify')->nullable();
            $table->integer('telegram_notify_status')->nullable();
            $table->string('background_img')->nullable();
            $table->string('background_vid')->nullable();
            $table->string('background_img_header')->nullable();
            $table->string('background_img_avatar')->nullable();
            $table->string('intro_page')->nullable();
            $table->string('currency')->nullable();
            $table->string('fees')->nullable();
            $table->string('ui_ux');
            $table->longText('ui_color')->nullable();
            $table->longText('user_ui_color')->nullable();
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
