<?php

namespace Wovosoft\LaravelStockManager\Enums;


use Wovosoft\LaravelCommon\Traits\HasEnumExtensions;

enum Types: string
{
    use HasEnumExtensions;

    case Stock_In = "in";
    case Stock_Out = "out";
}
