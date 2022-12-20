<?php

namespace App\Models;

use App\Models\Sallary;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubSallary extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $fillable = [
        'id',
        'id_sallary',
        'product_category',
        'quantity',
        'subtotal',
        'total',
    ];

    public function userSallary()
    {
        return $this->belongsTo(Sallary::class, 'id_sallary');
    }
}
