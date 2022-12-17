<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Product;
use App\Models\Sallary;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public $incrementing = false;
    protected $fillable = [
        'id',
        'id_position',
        'name',
        'email',
        'password',
        'address',
        'telp',
        'picture',
        'gender',
        'status_act',
        'email_verified_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getCreatedAtAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])->translatedFormat('l, d F Y');
    }

    public function getPictureAttribute($value)
    {
        if ($value) {
            return asset('storage/img/users/' . $value);
        } else {
            return asset('dist/img/users/no-image.jpeg');
        }
    }

    public function userPosition()
    {
        return $this->belongsTo(Position::class, 'id_position');
    }

    public function product()
    {
        return $this->hasMany(Product::class);
    }

    public function sallary()
    {
        return $this->hasMany(Sallary::class);
    }
}
