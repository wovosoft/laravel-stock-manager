<?php

namespace Wovosoft\LaravelStockManager\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Wovosoft\LaravelStockManager\Actions\HasStockRecords;

class StockRecordController extends Controller
{
    use HasStockRecords;
}
