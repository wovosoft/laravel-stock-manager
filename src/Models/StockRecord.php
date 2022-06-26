<?php

namespace Wovosoft\LaravelStockManager\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Wovosoft\LaravelStockManager\Enums\Types;
use Wovosoft\LaravelStockManager\Traits\HasTablePrefix;

class StockRecord extends Model
{
    use HasFactory, HasTablePrefix;

    protected static function boot()
    {
        parent::boot();
        static::created(function (self $record) {
            $stock = $record->currentStock()->firstOrNew();
            $stock->owner_type = $record->owner_type;
            $stock->owner_id = $record->owner_id;
            if ($record->type === Types::Stock_In) {
                $stock->quantity += $record->quantity;
            } elseif ($record->type === Types::Stock_Out) {
                $stock->quantity -= $record->quantity;
            }
            $stock->saveOrFail();
        });

        static::deleted(function (self $record) {
            $stock = $record->current_stock;
            if ($record->type === Types::Stock_In) {
                $stock->decrement("quantity", $record->quantity);
            } elseif ($record->type === Types::Stock_Out) {
                $stock->increment("quantity", $record->quantity);
            }
        });
    }

    protected $casts = [
        "type" => Types::class,
        "quantity" => "double"
    ];


    /**
     * Stock Of
     * @return MorphTo
     */
    public function owner(): MorphTo
    {
        return $this->morphTo("owner");
    }

    public function currentStock(): BelongsTo
    {
        return $this->belongsTo(CurrentStock::class, "owner_type", "owner_type")
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
