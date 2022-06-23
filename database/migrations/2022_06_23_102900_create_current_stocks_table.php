<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create(config("laravel-stock-manager.table.prefix") . 'current_stocks', function (Blueprint $table) {
            $table->id();
            /**
             * creates: owner_type and owner_id
             * example : owner_type = Product
             */
            $table->morphs("owner");
            $table->unsignedDouble("quantity");
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
        Schema::dropIfExists(config("laravel-stock-manager.table.prefix") . 'current_stocks');
    }
};
