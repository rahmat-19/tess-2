<?php

namespace App\Models;

use App\Models\User;
use App\Models\UserPermission;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permission extends Model
{
    use HasFactory;

    protected  $table = 'permission';

    protected $guarded = [];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_permission');
    }
}
