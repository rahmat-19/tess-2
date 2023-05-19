<?php

namespace App\Models;

use App\Models\Village;
use App\Models\Province;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class City extends Model
{
    use HasFactory;

    protected  $table = 'city';

    protected $guarded = [];

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function villages()
    {
        return $this->hasMany(Village::class);
    }
}
