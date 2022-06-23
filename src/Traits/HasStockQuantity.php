<?php

namespace Wovosoft\LaravelStockManager\Traits;

use Illuminate\Database\Eloquent\Relations\MorphOne;
use Wovosoft\LaravelStockManager\Models\CurrentStock;
use Wovosoft\LaravelStockManager\Models\StockRecord;

trait HasStockQuantity
{
    /**
     * @throws \Throwable
     */
    public function addToStock(int|float $quantity): bool|int
    {
        $record = new StockRecord();
        $record->owner_type = get_class($this);
        $record->owner_id = $this->id;
        $record->quantity = $quantity;
        return $record->saveOrFail();
    }

    public function removeFromStock(int|float $quantity): bool|int
    {
        return $this->currentStock()->firstOrNew()->decrement("quantity", $quantity);
    }

    public function currentStock(): MorphOne
    {
        return $this->morphOne(CurrentStock::class, 'owner');
    }
}
