<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    
    protected $fillable = [
        'name',
        'slug',
        'description'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

}
