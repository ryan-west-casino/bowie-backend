<?php

namespace App\Http\Controllers\Bowie\Games\Lib\ExternalGame;

use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;

class ExternalGameMeta extends BaseController
{
    public static function handle()
    {
        return [
                "id" => "mascot:princess_and_dwarfs_rockways",
                "name" => "Princess and Dwarfs",
                "type" => "external",
                "desc" => "External slots game.",
                "link" => "/game/external/mascot:princess_and_dwarfs_rockways",
                "class" => "\App\Http\Controllers\Bowie\Games\Lib\RockPaperScissors\RockPaperScissorsResult",
        ];
    }

}