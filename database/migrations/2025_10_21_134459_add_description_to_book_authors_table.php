<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('book_authors', function (Blueprint $table) {
            if (!Schema::hasColumn('book_authors', 'description')) {
                $table->string('description')->after('id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('book_authors', function (Blueprint $table) {
            $table->dropColumn('description');
        });
    }
};
