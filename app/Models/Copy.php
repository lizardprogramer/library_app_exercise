<?php

namespace App\Models;

use App\Models\Book;
use App\Models\User;
use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Copy extends Model
{
    use HasFactory;
    use UUID;

    protected $fillable = [
        'user_id',
        'book_id',
        'borrowed',
        'ISBN',
        'publisher',
        'language',
        'created_at',
        'updated_at'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function book(){
        return $this->belongsTo(Book::class, 'book_id');
    }
}
