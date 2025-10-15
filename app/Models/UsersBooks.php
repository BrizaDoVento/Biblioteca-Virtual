<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersBooks extends Model
{
    protected $fillable = ['user_id','book_id','status_id','start_date','end_date'];

    public function user() { return $this->belongsTo(User::class); }
    public function book() { return $this->belongsTo(Book::class); }
    public function status() { return $this->belongsTo(UsersBookStatus::class, 'status_id'); }
}
