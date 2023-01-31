<?php

namespace App\Models;

use App\Models\User;
use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Log extends Model
{
    use HasFactory;
    use UUID;

    protected $fillable = [
        'user_id',
        'description',
        'entity',
        'process',
        'created_at',
        'updated_at'
    ];

    public function scopeFilter($query, $filter){
        if($filter ?? false) {
            $query->where('entity', 'like', '%' . $filter . '%');
        }
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
