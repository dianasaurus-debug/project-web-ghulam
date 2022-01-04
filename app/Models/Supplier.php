<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['nama_supplier'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('deskripsi', 'like', '%'.$search.'%')
                    ->orWhere('alamat', 'like', '%'.$search.'%');
            });
        });
    }
    public function scopeOrderByName($query)
    {
        $query->orderBy('nama_supplier');
    }
}
