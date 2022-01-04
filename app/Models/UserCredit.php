<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCredit extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id', 'id');
    }
    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->whereHas('user', function($q) use ($search) {
                    $q->where('first_name', 'like', '%' . $search . '%')
                        ->orWhere('last_name', 'like', '%' . $search . '%');
                })->orWhereHas('admin', function($q) use ($search) {
                    $q->where('first_name', 'like', '%' . $search . '%')
                        ->orWhere('last_name', 'like', '%' . $search . '%');
                });
            });
        })->when($filters['user'] ?? null, function ($query, $user) {
            $query->where('user_id', $user);
        })->when($filters['admin'] ?? null, function ($query, $admin) {
            $query->where('admin_id', $admin);
        })->when($filters['jumlah'] ?? null, function ($query, $jumlah) {
            if($jumlah!=null){
                $query->whereBetween('jumlah_topup', $jumlah);
            }
        });
    }
}
