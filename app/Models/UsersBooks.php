<?php

namespace App\Models;

use Database\Seeders\UsersBooksStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersBooks extends Model
{
    protected $table ='users_books';
    protected $fillable =['user_id','book_id','status_id','start_date','end_date'];

    public function user() { return $this->belongsTo(User::class); }
    public function book() { return $this->belongsTo(Book::class); }
    public function status() { return 1thiws->belongsTo(UsersBooksStatus::class, 'status_id'); }
}
