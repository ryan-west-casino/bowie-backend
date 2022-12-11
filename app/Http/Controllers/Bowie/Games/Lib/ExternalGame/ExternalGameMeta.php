<?php

namespace App\Http\Controllers\Bowie\Games\Lib\ExternalGame;

use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;

class ExternalGameMeta extends BaseController
{
    public static function handle()
    {
      $games = file_get_contents(__DIR__ . '/../../games.json');

       return json_decode($games, true);
        /* format:
        return [
                "id" => "mascot:princess_and_dwarfs_rockways",
                "name" => "Princess and Dwarfs",
                "type" => "external",
                "desc" => "External slots game.",
                "link" => "/game/external/mascot:princess_and_dwarfs_rockways",
                "class" => [
                    "init" => "\ExternalGame\ExternalGameInit",
                    "meta" => "\ExternalGame\ExternalGameMeta",
                ],
        ];

        */
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
        ];
    }
}