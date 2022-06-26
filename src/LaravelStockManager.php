<?php

namespace Wovosoft\LaravelStockManager;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Wovosoft\LaravelStockManager\Enums\Types;
use Wovosoft\LaravelStockManager\Http\Controllers\CurrentStockController;
use Wovosoft\LaravelStockManager\Http\Controllers\StockRecordController;
use Wovosoft\LaravelStockManager\Models\StockRecord;

class LaravelStockManager
{
    /**
     * Creates a stock record and increases stock quantity
     * @param Model $model
     * @param int|float $quantity
     * @return bool
     * @throws \Throwable
     */
    public function add(Model $model, int|float $quantity): bool
    {
        $record = new StockRecord();
        $record->owner_type = get_class($model);
        $record->owner_id = $model->id;
        $record->quantity = $quantity;
        $record->type = Types::Stock_In;
        return $record->saveOrFail();
    }

    /**
     * Creates a stock record and decreases stock quantity
     * @param Model $model
     * @param int|float $quantity
     * @return bool
     * @throws \Throwable
     */
    public function remove(Model $model, int|float $quantity): bool
    {
        $record = new StockRecord();
        $record->owner_type = get_class($model);
        $record->owner_id = $model->id;
        $record->quantity = $quantity;
        $record->type = Types::Stock_Out;
        return $record->saveOrFail();
    }

    /**
     * @throws \Throwable
     */
    public function deleteRecord(StockRecord $stockRecord): bool
    {
        DB::beginTransaction();
        try {
            if ($stockRecord->deleteOrFail()) {
                $stockRecord->currentStock()->decrement("quantity", $stockRecord->quantity);
            }
            DB::commit();
            return true;
        } catch (\Throwable $throwable) {
            DB::rollBack();
            throw $throwable;
        }
    }

    public static function routes(): void
    {
        Route::prefix(config("laravel-stock-manager.routes.prefix"))
            ->name("current-stock.")
            ->group(function () {
                Route::controller(CurrentStockController::class)
                    ->prefix("stocks")
                    ->group(function () {
                        Route::post("/", "index")->name("index");
                        Route::post("/options", "options")->name("options");
                    });

                Route::controller(StockRecordController::class)
                    ->prefix("stock_records")
                    ->group(function () {
                        Route::put("/store", "store")->name("store");
                        Route::put("/update/{stock_record}", "update")->name("update");
                        Route::delete("/destroy/{stock_record}", "destroy")->name("destroy");
                        Route::post("/find/{stock_record}", "find")->name("find");
                        Route::post("/", "index")->name("index");
                        Route::post("/options", "options")->name("options");
                    });
            });
    }
}
