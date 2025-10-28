<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    // Campos permitidos para mass assignment
    protected $fillable = [
        'title',
        'author',
        'category',
        'language',
        'description',
        'status',
        'amount',
    ];

    // Relacionamento com empréstimos (UsersBooks)
    public function loans()
    {
        return $this->hasMany(UsersBooks::class, 'book_id');
    }

    // Opcional: escopo para livros disponíveis
    public function scopeAvailable($query)
    {
        return $query->where('amount', '>', 0);
    }
}
