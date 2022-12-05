<?php

namespace App\Http\Controllers\Bowie\Games\Lib\ThreeInARow;

use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;

class ThreeInARowMeta extends BaseController
{
    public static function handle()
    {
        return [
                "id" => "threeinarow",
                "name" => "Three in a Row",
                "desc" => "Get three in a row and win 12x your bet.",
                "link" => "/game/internal/threeinarow",
                "type" => "in-house",
                "class" => "\App\Http\Controllers\Bowie\Games\Lib\ThreeInARow\ThreeInARowResult.php",
        ];
    }

}