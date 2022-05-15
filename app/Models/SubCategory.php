<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }
    public function main_category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id', 'id');
    }
}
