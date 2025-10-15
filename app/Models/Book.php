<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category_id',
        'language_id',
        'author_id',
        'amount'
    ];

    // Relação com a categoria do livro
    public function category()
    {
        return $this->belongsTo(BookCategory::class, 'category_id');
    }

    // Relação com o idioma do livro
    public function language()
    {
        return $this->belongsTo(BookLanguage::class, 'language_id');
    }

    // Relação com o autor
    public function author()
    {
        return $this->belongsTo(BookAuthors::class, 'author_id');
    }
}
