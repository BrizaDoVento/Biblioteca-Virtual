<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('book_categories', function (Blueprint $table) {
            if (!Schema::hasColumn('book_categories', 'description')) {
                $table->string('description')->after('id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('book_categories', function (Blueprint $table) {
            $table->dropColumn('description');
        });
    }
};
