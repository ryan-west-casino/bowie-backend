<?php

namespace App\Http\Controllers\Bowie\Games;

use Illuminate\Http\Request;
use App\Models\User;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;
use App\Models\InplayBalances;
use Illuminate\Support\Facades\Cache;

class GamesKernel extends BaseController
{

    public function __construct()
    {
            $this->inplay_balances = new InplayBalances;
    }

    public function validate_int($input)
    {
        if(!is_integer($input)) {
            abort(400, "Input should be integer");
        }
    }

    public function game_byId($id) {
            return collect($this->loaded_games())->where('id', $id)->first() ?? abort(400, "Game with {$id} could not be found.");
    }

    public function loaded_games()
    {
        $games = Cache::get('games_json');
        if(!$games) {
            Cache::set('games_json', file_get_contents(__DIR__ . '/games.json'), now()->addMinutes(10));
            $games = Cache::get('games_json');
        }
        return json_decode($games, true);

    }

    public function process_game($debit, $credit, $currency, $game_data = NULL)
    {
        $currency = strtolower($currency);
        $this->debit((int) $debit, $currency);
        $this->credit((int) $credit, $currency);
        $this->win = $credit;
        $this->debit = $debit;
        $this->game_data = morph_array($game_data ?? '[]');
    }

    public function credit($amount, $currency)
    {
        $currency = strtolower($currency);
        $this->validate_int($amount);
        $balance_before = auth()->user()->$currency;
        $balance_after = $balance_before + $amount;
        $user = auth()->user();
        $user->$currency = $balance_after;
        $user->save();
        $this->credit = $amount;
        $this->new_balance = $balance_after;
    }

    public function debit($amount, $currency)
    {
        $currency = strtolower($currency);
        $this->validate_int($amount);
        $balance_before = auth()->user()->$currency;
        $balance_after = $balance_before - $amount;
        if($balance_after < 0) {
            abort(402, 'Insufficient balance');
        }
        $user = auth()->user();
        $user->$currency = $balance_after;
        $user->save();
        $this->debit = $amount;
        $this->new_balance = $balance_after;
    }
    public function transfer_to_inplay($currency)
    {
        $user_id = auth()->user()->id;
        $currency = strtolower($currency);
        $wallet_balance = (int) $this->user_balance($currency);
        if($wallet_balance > 0) {
            $current_inplay = $this->inplay_balances->get_balance($user_id, $currency);
            $new_balance = (int) ($current_inplay + $wallet_balance);
            $transaction_data = array(
                        "direction" => "to_thirdparty_inplay",
                        "amount" => $wallet_balance,
                        "currency" => $currency,
                        "old_inplay" => $current_inplay,
                        "new_inplay" => $new_balance,
                    );
            $set_balance_func = $this->inplay_balances->set_balance($user_id, $currency, $new_balance);

            $this->process_game($wallet_balance, 0, $currency, $transaction_data);
        }
    }

    public function transfer_to_wallet($currency)
    {
        $user_id = auth()->user()->id;
        $currency = strtolower($currency);
        $wallet_balance = (int) $this->user_balance($currency);
        $current_inplay = $this->inplay_balances->get_balance($user_id, $currency);
        if($current_inplay > 0) {

            $transaction_data = array(
                        "direction" => "to_wallet",
                        "amount" => $current_inplay,
                        "currency" => $currency,
                        "old_inplay" => $current_inplay,
                        "new_inplay" => 0,
                    );
            $this->process_game(0, $current_inplay, $currency, $transaction_data);
            $set_balance_func = $this->inplay_balances->set_balance($user_id, $currency, 0);
        }
    }

    public function user_balance($currency)
    {
        $currency = strtolower($currency);
        return auth()->user()->$currency;
    }
}









