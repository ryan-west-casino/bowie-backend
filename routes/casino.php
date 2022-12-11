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

$router->post('api/game/init', [
        'as' => 'casino.bowie.game.init', 'uses' => '\App\Http\Controllers\Bowie\API\InitGame@handle'
]);
$router->post('api/game/mock/{user}/play', [
        'as' => 'casino.bowie.game.mock.response', 'uses' => '\App\Http\Controllers\Bowie\API\MockThirdpartyIncoming@handle'
]);

$router->get('api/game/mock/{user}/play', [
        'as' => 'casino.bowie.game.mock.response', 'uses' => '\App\Http\Controllers\Bowie\API\MockThirdpartyIncoming@handle'
]);
  //All the routes you want to allow CORS for


//$router->get('api/game/external/callback', [
//        'as' => 'casino.bowie.game.external.callback', 'uses' => '\App\Http\Controllers\Bowie\Games\Lib\ExternalGame\ExternalGameCallback@handle'
//]);