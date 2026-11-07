<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class IngredientCategory extends Model
{
    protected $table = 'ingredient_categories';

    public $timestamps = false;

    protected $fillable = [
        'name',
    ];

    public function ingredients(): HasMany
    {
        return $this->hasMany(
            IngredientMaster::class,
            'category_id'
        );
    }
}