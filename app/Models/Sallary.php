<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Support\Carbon;
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
        'quantity',
        'total',
        'payment_status'
    ];

    public function getPeriodeAttribute()
    {
        return Carbon::parse($this->attributes['periode'])->translatedFormat('F Y');
    }

    public function userSallary()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
