<?php

namespace Wovosoft\LaravelStockManager\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
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
        return $this->hasMany(StockRecord::class, "owner_type", "owner_type")
            ->where("owner_id", "=", $this->owner_id);
    }

    /**
     * owner_type = Product::class
     * @param Builder $builder
     * @param string $owner
     * @return Builder
     */
    public function scopeOf(Builder $builder, string $owner): Builder
    {
        return $builder->where("owner_type", "=", $owner);
    }
}
