<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dealer extends Model
{
    /** @use HasFactory<\Database\Factories\DealerFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function run(): HasMany
    {
        return $this->hasMany(Run::class);
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Store::class, 'dealer_store');
    }
}
