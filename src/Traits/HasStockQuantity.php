<?php

namespace Wovosoft\LaravelStockManager\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Wovosoft\LaravelStockManager\Facades\LaravelStockManager as Stock;
use Wovosoft\LaravelStockManager\Models\CurrentStock;
use Wovosoft\LaravelStockManager\Models\StockRecord;


/**
 * Should be used in Models which should have stock quantities
 */
trait HasStockQuantity
{
    /**
     * @throws \Throwable
     */
    public function addStock(int|float $quantity): bool|int
    {
        return Stock::add($this, $quantity);
    }

    public function removeStock(int|float $quantity): bool|int
    {
        return Stock::remove($this, $quantity);
    }

    public function currentStock(): MorphOne
    {
        return $this->morphOne(CurrentStock::class, 'owner');
    }

    public function quantity(): Attribute
    {
        return new Attribute(
            get: fn() => $this->currentStock?->quantity
        );
    }

    public function stockRecords(): MorphMany
    {
        return $this->morphMany(StockRecord::class, "owner");
    }
}
