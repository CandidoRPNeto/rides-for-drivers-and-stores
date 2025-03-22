<?php

namespace App\Models;

use App\Models\Scopes\StoreScope;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Run extends Model
{
    use HasUuids, SoftDeletes;

    protected $fillable = [
        'dealer_id',
        'store_id',
        'finished_at',
        'started_at'
    ];

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function dealer(): BelongsTo
    {
        return $this->belongsTo(Dealer::class);
    }

    public function deliveries(): HasMany
    {
        return $this->hasMany(Delivery::class);
    }


    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new StoreScope);
        static::creating(function ($data) {
            $store = auth()->user()->store;
            if ($store->runs == 0) {
                throw new \Exception("'Runs' in store are not enough", 1);
            }
            $store->decrement('runs');
            $data->store_id = $store->id;
        });
        static::deleting(function ($run) {
            if ($run->dealer->status == 2) {
                $run->dealer->update(['status' => 1]);
            }
            $run->deliveries()->where('status', 2)->update(['status' => 1]);
        });
    }
}
