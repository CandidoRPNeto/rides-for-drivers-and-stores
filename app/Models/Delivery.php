<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Delivery extends Model
{
    /** @use HasFactory<\Database\Factories\DeliveryFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'run_id',
        'rating_id',
        'destiny_id',
        'code',
        'position',
        'finished_at'
    ];

    public function run(): BelongsTo
    {
        return $this->belongsTo(Run::class);
    }

    public function rating(): BelongsTo
    {
        return $this->belongsTo(Rating::class);
    }

    public function destiny(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }
}
