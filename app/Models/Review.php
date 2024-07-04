<?php

namespace App\Models;

use App\Models\User;
use App\Models\Homestay;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'homestays_id',
        'rating',
        'review',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function homestay(): BelongsTo
    {
        return $this->belongsTo(Homestay::class, 'homestays_id', 'id');
    }
}
