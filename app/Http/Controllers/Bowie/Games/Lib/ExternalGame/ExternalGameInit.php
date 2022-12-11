<?php

namespace App\Http\Controllers\Bowie\Games\Lib\ExternalGame;

use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Bowie\Games\GamesKernel;

class ExternalGameInit extends BaseController
{


    /**
    * Mock external game init, normally you would write your 3rd party library over here
    * IMPORTANT: Balances on mock api are "deposited" in 3rd party balance account, this is so we don't have to process callbacks (on localhost etc)
    * When we init the game, we "transfer" the player's balance to 3rd party database.
    * Once game "unloads" (closed by user) or by user request in lobby it will transfer funds back into the wallet balance.
    *
    * @return void
    */
    public function __construct()
    {
        $this->api = new mock\MockThirdParty();
        $this->game_kernel = new GamesKernel;
    }
    public function handle($game, $currency)
    {
        $this->game_kernel->transfer_to_inplay($currency);
        return $this->api->create_session($game, $currency);
    }

}
