<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UsersBookStatus;

class UsersBooksStatus extends Seeder
{
    public function run(): void
    {
        UsersBookStatus::create([
            ['description' => 'Emprestado'],
            ['description' => 'Devolvido'],
        ]);
    }
}
