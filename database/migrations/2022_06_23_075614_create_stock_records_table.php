<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Wovosoft\LaravelStockManager\Enums\Types;

return new class extends Migration {
    /**
     * The purpose of this table is to hold the stock in and out records.
     * This table is a polymorphic tables, which means multiple models can use
     * this table for same purpose.
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create(config("laravel-stock-manager.table.prefix") . 'stock_records', function (Blueprint $table) {
            $table->id();

            //the entity/model for which the record is being generated
            $table->morphs("owner");

            //whether stock in or out
            $table->enum("type", Types::values());

            //quantity can be any amount int/float etc. But should be unsigned.
            $table->unsignedDouble("quantity");

            //note for the record
            $table->text("note")->nullable();

            //the account which is used to add the stock record
            $table->unsignedBigInteger("user_id")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(config("laravel-stock-manager.table.prefix") . 'stock_records');
    }
};
