<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    use HasFactory;
    public function kriteria_fuzzy()
    {
        return $this->hasOne(KriteriaFuzzy::class, 'id_kriteria', 'id');
    }
}
