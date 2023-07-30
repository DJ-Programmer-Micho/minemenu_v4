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
        Schema::create('mainmenu_translators', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_id')->references('id')->on('mainmenus')->onDelete('cascade')->onUpdate('cascade');
            $table->string('locale',5);
            $table->string('name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mainmenu_translators');
    }
};
