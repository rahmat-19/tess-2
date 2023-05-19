<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rekening extends Model
{
    use HasFactory;

    protected $table = 'rekening';
    protected $guarded = [];

    public function users()
    {
        return $this->belongsToMany(User::class, 'rekening_user');
    }
}