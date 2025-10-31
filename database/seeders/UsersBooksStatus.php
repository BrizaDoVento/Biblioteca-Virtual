<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UsersBookStatus;

class UsersBooksStatus extends Seeder
{
    public function run()
    {
        UsersBookStatus::updateOrCreate(['description' => 'Emprestado']);
        UsersBookStatus::updateOrCreate(['description' => 'Devolvido']);
    }
}
