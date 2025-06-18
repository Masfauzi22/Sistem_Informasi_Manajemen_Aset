<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Asset extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'category_id',
        'location_id',
        'serial_number',
        'purchase_date',
        'purchase_price',
        'status',
        'image',
    ];

    // Mendefinisikan bahwa sebuah Aset 'milik' satu Kategori
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // Mendefinisikan bahwa sebuah Aset 'milik' satu Lokasi
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }
}