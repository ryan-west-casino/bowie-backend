<?php

namespace App\Http\Controllers\Bowie\Games;

use Illuminate\Http\Request;
use App\Models\User;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;

class GamesKernel extends BaseController
{
    public function validate_int($input)
    {
        if(!is_integer($input)) {
            abort(400, "Input should be integer");
        }
    }

    public function loaded_games()
    {
        return [
                \App\Http\Controllers\Bowie\Games\Lib\RockPaperScissors\RockPaperScissorsMeta::handle(),
                \App\Http\Controllers\Bowie\Games\Lib\ThreeInARow\ThreeInARowMeta::handle(),
                //\App\Http\Controllers\Bowie\Games\Lib\ExternalGame\ExternalGameMeta::handle(),
        ];
    }

    public function process_game($debit, $credit, $currency, $game_data = NULL)
    {
        $this->debit((int) $debit, $currency);
        $this->credit((int) $credit, $currency);
        $this->win = $credit;
        $this->debit = $debit;
        $this->game_data = morph_array($game_data ?? '[]');
    }

    public function credit($amount, $currency)
    {
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

    public function user_balance($currency)
    {
        return auth()->user()->$currency;
    }
}









