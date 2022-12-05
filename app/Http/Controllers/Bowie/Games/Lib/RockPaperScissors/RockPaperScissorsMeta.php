<?php

namespace App\Http\Controllers\Bowie\Games\Lib\RockPaperScissors;

use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;

class RockPaperScissorsMeta extends BaseController
{
    public static function handle()
    {
        return [
                "id" => "rockpaperscissors",
                "name" => "Rock Paper Scissors",
                "desc" => "Old game. Play against the house or multiplayer.",
                "type" => "in-house",
                "link" => "/game/internal/rockpaperscissors",
                "class" => "\App\Http\Controllers\Bowie\Games\Lib\RockPaperScissors\RockPaperScissorsResult",
        ];
    }

}