<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BahanPangan extends Model
{
    use HasFactory;

    protected $table = 'bahan_pangan';

    protected $fillable = [
        'category_id',
        'name',
        'default_unit',
        'image_path',
        'calories_per_100g',
        'protein_g',
        'fat_g',
        'carbs_g',
        'iron_mg',
        'zinc_mg',
        'vitamin_a_mcg',
        'vitamin_c_mg',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}