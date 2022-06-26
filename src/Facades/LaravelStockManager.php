<?php

namespace Wovosoft\LaravelStockManager\Facades;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Facade;
use Wovosoft\LaravelStockManager\Models\StockRecord;

/**
 * @method int|bool add(Model $model, int|float $quantity)
 * @method int|bool remove(Model $model, int|float $quantity)
 * @method bool  deleteRecord(StockRecord $stockRecord)
 */
class LaravelStockManager extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'laravel-stock-manager';
    }
}
