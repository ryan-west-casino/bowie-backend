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
                "desc" => "Double your money if you win, even-money on draw",
                "type" => "in-house",
                "link" => "/game/internal/rockpaperscissors",
                "class" => [
                    "meta" => "\RockPaperScissors\RockPaperScissorsMeta",
                    "result" => "\RockPaperScissors\RockPaperScissorsResult",
                ],
        ];
    }

    public static function init_meta()
    {  // passed to frontend when player loads game
        return [
                "loader" => "direct",
                "theme" => NULL,
                "locales" => [
                    "en" => [
                            "bet_button" => "Place Bet",
                            "gamerules_button" => "Game Rules",
                        ],
                ],
                "betsizes" => [
                    '100'
                ],
        ];
    }

}