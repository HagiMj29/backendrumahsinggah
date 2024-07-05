<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HomestayNearHospital extends Model
{
    use HasFactory;
    protected $fillable = [
        'hospital',
        'homestays_id',
        'google_maps',
    ];


    public function homestay(): BelongsTo
    {
        return $this->belongsTo(Homestay::class, 'homestays_id', 'id');
    }
}
