<?php

namespace App\Models;

use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $fillable = [
        'id',
        'id_category',
        'id_user',
        'name',
        'quantity',
        'completed_date',
    ];

    public function getCompletedDateAttribute()
    {
        return Carbon::parse($this->attributes['completed_date'])->translatedFormat('l, d F Y');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'id_category');
    }

    public function worker()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
