<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Rating extends Model
{
    use HasUuids, HasFactory;

    protected $fillable = [
        'description',
        'score'
    ];

    public function delivery(): HasOne
    {
        return $this->hasOne(Delivery::class);
    }
}
