<?php
use Illuminate\Http\Request;

$router->get('api/lobby', [
        'as' => 'casino.bowie.lobbylist', 'uses' => '\App\Http\Controllers\Bowie\API\LobbyList@handle'
]);
$router->post('api/game/internal/rockpaperscissors', [ // Game Result
        'as' => 'casino.bowie.game.rps', 'uses' => '\App\Http\Controllers\Bowie\Games\Lib\RockPaperScissors\RockPaperScissorsResult@handle'
]);
$router->post('api/game/internal/threeinarow', [ // Game Result
        'as' => 'casino.bowie.game.threeinarow', 'uses' => '\App\Http\Controllers\Bowie\Games\Lib\ThreeInARow\ThreeInARowResult@handle'
]);

//$router->get('api/game/external/init/{slug}', [
//        'as' => 'casino.bowie.game.external.init', 'uses' => '\App\Http\Controllers\Bowie\API\InitExternalGame@handle'
//]);

//$router->get('api/game/external/callback', [
//        'as' => 'casino.bowie.game.external.callback', 'uses' => '\App\Http\Controllers\Bowie\Games\Lib\ExternalGame\ExternalGameCallback@handle'
//]);