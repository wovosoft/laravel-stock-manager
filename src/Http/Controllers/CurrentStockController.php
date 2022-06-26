<?php

namespace Wovosoft\LaravelStockManager\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Wovosoft\LaravelStockManager\HasCurrentStock;

class CurrentStockController extends Controller
{
    use HasCurrentStock;
}
