<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'latitude',
        'longitude'
    ];

    public function delivery(): HasOne
    {
        return $this->hasOne(Delivery::class);
    }
}
