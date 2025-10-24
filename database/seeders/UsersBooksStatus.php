<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersBooksStatus extends Seeder
{
    public function run()
    {
        DB::table('users_books_status')->insert([
            ['description' => 'Emprestado'],
            ['description' => 'Devolvido'],
        ]);
    }
}
