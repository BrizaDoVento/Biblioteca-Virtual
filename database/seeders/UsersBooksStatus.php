<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class UsersBooksStatus extends Seeder
{
    public function run(): void
    {
        if (Schema::hasTable('users_books_status')) {
            DB::table('users_books_status')->insert([
                ['description' => 'Emprestado', 'created_at' => now(), 'updated_at' => now()],
                ['description' => 'Devolvido',  'created_at' => now(), 'updated_at' => now()],
            ]);
        } else {
            $this->command->warn('⚠️ Tabela users_books_status não existe. Rode primeiro: php artisan migrate');
        }
    }
}
