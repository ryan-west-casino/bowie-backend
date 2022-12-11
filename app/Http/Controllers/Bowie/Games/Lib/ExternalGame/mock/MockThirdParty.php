<?php

namespace App\Http\Controllers\Bowie\Games\Lib\ExternalGame\mock;

use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;
use App\Models\InplayBalances;
use App\Http\Controllers\Bowie\Games\GamesKernel;
class MockThirdParty extends BaseController
{

    public function __construct()
    {
            $this->inplay_balances = new InplayBalances;
            $this->game_kernel = new GamesKernel;
    }

    /**
    * Mock external game init, normally you would write your 3rd party library over here
    *
    * @return void
    */
    public function create_session($game_id, $currency)
    {

            $user_id = auth()->user()->id;
            $game_session_url = $this->inplay_balances->create_game_session($user_id, $currency, $game_id);
            $inplay_balance = $this->inplay_balances->get_balance($user_id, $currency);

            $data = [
                'link' => $game_session_url,
                'inplay_balance' => $inplay_balance,
                'game_html' => base64_encode($this->get_html($game_session_url)),
            ];
            return $data;
     }


    public function get_html($url)
    {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (X11; Linux x86_64) Gecko/20100101 Firefox/102.0');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT ,0);
            curl_setopt($ch, CURLOPT_TIMEOUT, 5);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $html = curl_exec($ch);
            curl_close($ch);
            $html = str_replace('<script src="main.js"', '<script src="http://localhost:3000/game_assets/mascot/script.js" defer="" type="text/javascript"></script><script src="main.js"', $html);
            return $html;
    }

}


