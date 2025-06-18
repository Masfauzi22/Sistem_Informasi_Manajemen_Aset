<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * Mendefinisikan bahwa satu Kategori memiliki banyak Aset.
     * Ini adalah "jembatan" ke tabel assets.
     */
    public function assets(): HasMany
    {
        return $this->hasMany(Asset::class);
    }
}