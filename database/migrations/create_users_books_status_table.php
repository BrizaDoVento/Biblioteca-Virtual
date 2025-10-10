<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('users_books_status', function (Blueprint $table) {
            $table->id();
            $table->string('description'); // Emprestado, Devolvido
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users_books_status');
    }
};
