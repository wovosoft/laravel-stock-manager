<?php

namespace Wovosoft\LaravelStockManager\Facades;

use Illuminate\Support\Facades\Facade;

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
