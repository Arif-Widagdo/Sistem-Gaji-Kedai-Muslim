<?php

namespace App\Models;

use App\Models\User;
use App\Models\Position;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sallary extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $fillable = [
        'id',
        'id_user',
        'total_sallary',
        'order_status',
        'period',
    ];

    public function userSallary()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
