<?php

namespace Wovosoft\LaravelStockManager\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Wovosoft\LaravelStockManager\Enums\Types;
use Wovosoft\LaravelStockManager\Traits\HasTablePrefix;

class StockRecord extends Model
{
    use HasFactory, HasTablePrefix;

    protected $casts = [
        "type" => Types::class,
        "quantity" => "double"
    ];


    protected static function boot()
    {
        parent::boot();

        static::creating(function (self $stockRecord) {
            if (!$stockRecord->current_stock) {
                $currentStock = new CurrentStock();
                $currentStock->owner_type = $stockRecord->owner_type;
                $currentStock->owner_id = $stockRecord->owner_id;
                $currentStock->quantity = 0;
                $currentStock->saveOrFail();
                $stockRecord->current_stock_id = $currentStock->id;
            }
        });

        static::created(function (self $stockRecord) {
            if ($stockRecord->type === Types::Stock_In) {
                $stockRecord
                    ->current_stock
                    ->increment("quantity", $stockRecord->quantity);
            } elseif ($stockRecord->type === Types::Stock_Out) {
                $stockRecord
                    ->current_stock
                    ->decrement("quantity", $stockRecord->quantity);
            }
        });

        static::updated(function (self $stockRecord) {
            $adjust = $stockRecord->getAttribute("quantity") - $stockRecord->quantity;
            $stockRecord->currentStock->increment($adjust);
        });

        static::deleted(function (self $stockRecord) {
            $stockRecord->currentStock->decrement("quantity", $stockRecord->quantity);
        });
    }

    public function owner(): MorphTo
    {
        return $this->morphTo("owner");
    }

    /**
     * @return BelongsTo
     */
    public function currentStock(): BelongsTo
    {
        return $this->belongsTo(CurrentStock::class);
    }
}
