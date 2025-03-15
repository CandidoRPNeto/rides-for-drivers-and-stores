<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rating extends Model
{
    use SoftDeletes, HasUuids;

    protected $fillable = [
        'description',
        'score'
    ];

    public function delivery(): HasOne
    {
        return $this->hasOne(Delivery::class);
    }
}
