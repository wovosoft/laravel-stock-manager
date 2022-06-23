<?php

namespace Wovosoft\LaravelStockManager\Traits;

trait HasTablePrefix
{
    public function __construct(...$attributes)
    {
        if (config("laravel-stock-manager.table.prefix")) {
            $this->table = config("laravel-stock-manager.table.prefix") . parent::getTable();
        }
        parent::__construct($attributes);
    }
}
