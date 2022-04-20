<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function category()
    {
        return $this->belongsTo(SubCategory::class, 'category_id', 'id');
    }
    public function criterias()
    {
        return $this->hasMany(ProductKriteria::class, 'product_id', 'id');
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }
    public function cart()
    {
        return $this->hasOne(Cart::class);
    }
    public function letak()
    {
        return $this->belongsTo(LetakBarang::class, 'letak_id', 'id');
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('nama_barang', 'like', '%'.$search.'%')
                    ->orWhere('kode_barang', 'like', '%'.$search.'%')
                    ->orWhere('deskripsi', 'like', '%'.$search.'%');
            });
        })->when($filters['category'] ?? null, function ($query, $category) {
            $query->where('category_id', $category);
        })->when($filters['harga'] ?? null, function ($query, $harga) {
            if($harga!=null){
                $query->whereBetween('harga_jual', $harga);
            }
        })->when($filters['stock'] ?? null, function ($query, $stock) {
            if($stock!=null){
                $query->whereBetween('stok', $stock);
            }
        });
    }
    public function scopeOrderByName($query)
    {
        $query->orderBy('nama_barang');
    }

}
