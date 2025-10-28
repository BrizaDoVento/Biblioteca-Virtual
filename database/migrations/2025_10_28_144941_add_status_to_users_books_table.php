<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToUsersBooksTable extends Migration
{
    public function up(): void
    {
        Schema::table('users_books', function (Blueprint $table) {
            $table->string('status')->default('Emprestado')->after('book_id');
        });
    }

    public function down(): void
    {
        Schema::table('users_books', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
