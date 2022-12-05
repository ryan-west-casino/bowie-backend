<?php

namespace App\Http\Controllers\Bowie\Games\Lib\ExternalGame;

use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;
class ExternalGameInit extends BaseController
{
    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct()
    {
        $this->base_url = 'https://ns363376.ip-91-121-179.eu/api/createSession';
        $this->operator_key = 'fc1e57a870d3893e8910e591058ea187';
        $this->operator_secret = 'ad8f1481f520';
        $this->build_create_session_url = $this->create_session_builder($this->base_url);
        //$this->middleware('auth:api');
    }

public function handle($game_id, $currency, $player)
{
    $s = "?game={$game_id}&player={$player}&currency=USD&operator_key={$this->operator_key}&mode=real";
    $url = $this->base_url . $s;

    return $url;
    //return $this->create_session('wainwright', '1234', 'USD', 'real');
}


public function create_session_builder($base)
{
    $s = '?game=wainwright&player=1234&currency=USD&operator_key=&mode=real';
}




}
