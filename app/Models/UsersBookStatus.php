<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersBookStatus extends Model
{
    protected $fillable = ['description'];

    const EMPRESTADO = 1;
    const DEVOLVIDO = 2;
}
