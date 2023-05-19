<?php

namespace App\Models;

use App\Models\Role;
use App\Models\Village;
use App\Models\Rekening;
use App\Models\EventUser;
use App\Models\Subdomain;
use App\Models\Permission;
use App\Models\PreweddingImage;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'kode_referal', 'village_id', 'subdomain_id', 'remember_token'
    ];

    public function village()
    {
        return $this->belongsTo(Village::class);
    }

    public function subdomain()
    {
        return $this->hasOne(Subdomain::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'user_permission');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_role');
    }

    public function rekenings()
    {
        return $this->belongsToMany(Rekening::class, 'rekening_user');
    }

    public function prewedding_image()
    {
        return $this->hasMany(PreweddingImage::class);
    }

    public function event_user()
    {
        return $this->hasOne(EventUser::class);
    }
}
