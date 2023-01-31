<?php

namespace App\Models;

use App\Models\User;
use App\Traits\UUID;
use App\Models\Author;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory;
    use UUID;

    protected $fillable = [
        'title',
        'author_id',
        'description',
        'picture',
        'created_at',
        'updated_at'
    ];

    public function copys(){
        return $this->hasMany(Copy::class, 'book_id');
    }

    public function author(){
        return $this->belongsTo(Author::class, 'author_id');
    }
}
