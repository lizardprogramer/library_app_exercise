<?php

namespace App\Models;

use App\Models\User;
use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;
    use UUID;

    protected $fillable = [
        'name',
        'description',
        'admin_permission'
    ];

    public function users(){
        return $this->hasMany(User::class, 'role_id');
    }
}
