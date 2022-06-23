<?php

namespace Wovosoft\LaravelStockManager\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Wovosoft\LaravelStockManager\Traits\HasTablePrefix;

class CurrentStock extends Model
{
    use HasFactory, HasTablePrefix;

    public function owner(): MorphTo
    {
        return $this->morphTo("owner");
    }

    /**
     * @return HasMany
     */
    public function records(): HasMany
    {
        return $this->hasMany(StockRecord::class);
    }
}
