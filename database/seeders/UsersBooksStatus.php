<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UsersBookStatus;

class UsersBooksStatusSeeder extends Seeder
{
    public function run(): void
    {
        UsersBookStatus::insert([
            ['description' => 'Emprestado'],
            ['description' => 'Devolvido'],
        ]);
    }
}
