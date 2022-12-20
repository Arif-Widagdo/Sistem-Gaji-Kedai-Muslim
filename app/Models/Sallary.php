<?php

namespace App\Models;

use App\Models\User;
use App\Models\SubSallary;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sallary extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $fillable = [
        'id',
        'id_user',
        'periode',
        'payroll_time',
        'order_status'
    ];

    public function userSallary()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function subSallary()
    {
        return $this->hasMany(SubSallary::class);
    }
}
