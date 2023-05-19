<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PreweddingImage extends Model
{
    use HasFactory;

    protected $table = 'prewedding_images';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
