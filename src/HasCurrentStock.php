<?php

namespace Wovosoft\LaravelStockManager;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Wovosoft\LaravelCommon\Helpers\Data;
use Wovosoft\LaravelStockManager\Models\CurrentStock;

trait HasCurrentStock
{
    public function index(Request $request): LengthAwarePaginator
    {
        return Data::paginate(CurrentStock::query(), $request);
    }

    public function options(Request $request): Collection|array
    {
        return Data::options(CurrentStock::query(), $request);
    }
}
