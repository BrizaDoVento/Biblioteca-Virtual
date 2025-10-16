<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author_id',
        'category_id',
        'language_id',
        'amount',
    ];

    public function author()
    {
        return $this->belongsTo(BookAuthors::class);
    }

    public function category()
    {
        return $this->belongsTo(BookCategory::class);
    }

    public function language()
    {
        return $this->belongsTo(BookLanguage::class);
    }
}
