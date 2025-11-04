<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class UsersBooks extends Model
{
    protected $table = 'users_books'; // só se o nome do model não seguir plural padrão

    protected $fillable = [
        'user_id','book_id','status_id','start_date','end_date'
    ];

    public function book() { return $this->belongsTo(Book::class,'book_id'); }
    public function user() { return $this->belongsTo(User::class,'user_id'); }
    public function getStatus() { return $this->belongsTo(UsersBookStatus::class,'status_id'); }
}
