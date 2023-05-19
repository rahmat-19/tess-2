<?php

namespace App\Models;

use App\Models\User;
use App\Models\Greeting;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subdomain extends Model
{
    use HasFactory;

    protected $table = 'subdomain';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function greeting()
    {
        return $this->hasOne(Greeting::class, 'greeting');
    }
}
