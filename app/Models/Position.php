<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Position extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $fillable = [
        'id',
        'name',
        'slug',
    ];

    public function userPosition()
    {
        return $this->hasMany(User::class);
    }
}
