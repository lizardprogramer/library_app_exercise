<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Author extends Model
{
    use HasFactory;
    use UUID;

    protected $fillable = [
        'name',
        'biography',
        'picture',
        'created_at',
        'updated_at'
    ];

    public function books(){
        return $this->hasMany(Book::class, 'author_id');
    }
}
