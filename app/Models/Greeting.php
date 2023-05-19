<?php

namespace App\Models;

use App\Models\Subdomain;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Greeting extends Model
{
    use HasFactory;
    
    protected $table = 'greeting';
    protected $guarded = [];

    public function subdomain()
    {
        return $this->belongsTo(Subdomain::class, 'domain_id');
    }
}
