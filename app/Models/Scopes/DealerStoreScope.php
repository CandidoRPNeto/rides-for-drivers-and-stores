<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class DealerStoreScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        $store = auth()->user()->store;
        $builder
        ->join('dealer_store', 'dealer_store.dealer_id', '=', 'dealers.id')
        ->where('dealer_store.store_id', $store->id);
    }
}
