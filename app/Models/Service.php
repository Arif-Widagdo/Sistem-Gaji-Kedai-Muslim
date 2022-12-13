<?php

namespace App\Models;

use App\Models\Category;
use App\Models\Position;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $fillable = [
        'id',
        'id_position',
        'id_category',
        'sallary'
    ];

    // protected $with = ['position', 'category'];

    public function position()
    {
        return $this->belongsTo(Position::class, 'id_position');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'id_category');
    }
}
