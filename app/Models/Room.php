<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $fillable = [
        'homestays_id',
        'type',
        'description',
        'quota',
        'price',
    ];

    public function getFormattedPriceAttribute()
    {
        return 'Rp. ' . number_format($this->price, 0, ',', '.');
    }

    public function homestay(): BelongsTo
    {
        return $this->belongsTo(Homestay::class, 'homestays_id', 'id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(RoomImage::class, 'room_id');
    }
}
