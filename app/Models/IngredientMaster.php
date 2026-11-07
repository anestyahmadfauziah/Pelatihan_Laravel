<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IngredientMaster extends Model
{
    protected $table = 'ingredients_master';

    const UPDATED_AT = null;

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

    public function category(): BelongsTo
    {
        return $this->belongsTo(
            IngredientCategory::class,
            'category_id'
        );
    }
}