<?php

namespace App\Models;

use App\Models\Scopes\RunScope;
use App\Models\Scopes\StoreScope;
use App\Observers\DeliveryObserver;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Delivery extends Model
{
    /** @use HasFactory<\Database\Factories\DeliveryFactory> */
    use HasFactory, SoftDeletes, HasUuids;

    protected $fillable = [
        'store_id',
        'run_id',
        'rating_id',
        'location_id',
        'name',
        'phone',
        'status',
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

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new StoreScope);
    }
}
