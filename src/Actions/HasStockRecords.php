<?php

namespace Wovosoft\LaravelStockManager\Actions;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Wovosoft\LaravelCommon\Helpers\Data;
use Wovosoft\LaravelStockManager\Models\StockRecord;

trait HasStockRecords
{
    /**
     * @throws \Throwable
     */
    public function store(Request $request): JsonResponse
    {
        return Data::store(new StockRecord(), $request);
    }

    /**
     * @throws \Throwable
     */
    public function update(StockRecord $stockRecord, Request $request): JsonResponse
    {
        return Data::store($stockRecord, $request);
    }

    /**
     * @throws \Throwable
     */
    public function destroy(StockRecord $stockRecord): JsonResponse
    {
        return Data::destroy($stockRecord);
    }

    public function find(StockRecord $stockRecord, Request $request): string
    {
        return $stockRecord->toJson();
    }

    public function index(Request $request): LengthAwarePaginator
    {
        return Data::paginate(StockRecord::query(), $request);
    }

    public function options(Request $request): Collection|array
    {
        return Data::options(StockRecord::query(), $request);
    }
}
