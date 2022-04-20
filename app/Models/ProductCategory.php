<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function sub_categories()
    {
        return $this->hasMany(SubCategory::class, 'category_id', 'id');
    }
    public function scopeOrderById($query)
    {
        $query->orderBy('id');
    }
    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('nama_kategori', 'like', '%'.$search.'%');
            });
        });
    }
}
