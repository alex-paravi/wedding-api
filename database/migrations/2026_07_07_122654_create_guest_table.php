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
        Schema::create('guests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('side');
            $table->string('category');
            $table->string('status');
            // Меняем старое поле на внешний ключ, привязанный к таблице tables
            // nullable() — потому что гость может быть еще не рассажен за стол
            // nullOnDelete() — если стол удалят, гость не пропадет, а просто получит null в это поле
            $table->foreignId('table_id')->nullable()->constrained()->nullOnDelete();
            // Уникальный токен для безопасного публичного доступа по ссылке
            $table->string('invitation_token')->nullable()->unique();
            // Пожелания по меню или информация об аллергиях
            $table->string('dietary_preferences')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guest');
    }
};
