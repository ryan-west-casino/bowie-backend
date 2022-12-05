<?php

namespace App\Http\Controllers\Bowie\Games\Lib\ThreeInARow;

use Illuminate\Http\Request;
use App\Models\User;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Bowie\API\ResponseTrait;
use App\Http\Controllers\Bowie\Games\GamesKernel;
class ThreeInARowResult extends BaseController
{
    use ResponseTrait;

    public function __construct(Request $request)
    {
        $this->middleware('auth:api');
        $this->gamekernel = new GamesKernel();
        $this->debit = (int) $request->bet;
        $this->credit = 0;
        $this->rng = NULL;
        $this->rng_verbose = $this->rng_to_symbol(rand(1, 4)) . $this->rng_to_symbol(rand(1, 4)) . $this->rng_to_symbol(rand(1, 4));
        $this->print_result = $this->print_result();
        $this->currency = strtolower($request->currency);
    }

    public function handle(Request $request)
    {
        $this->validate($request, [
                'bet' => 'required|integer|min:1|max:1000000000',
                'currency' => 'required|string|min:1|max:5',
        ]);
        $bet = $this->debit;
        $result = $this->rng_verbose;
        $currency = $this->currency;

        if($this->outcome === 'win') {
                $this->credit = ($bet * 12);
                $this->gamekernel->process_game($bet, $this->credit, $currency);
        }

        if($this->outcome === 'loss') {
            $this->credit = 0;
            $this->gamekernel->process_game($bet, 0, $currency);
        }

        return $this->response_builder();
    }

    public function response_builder()
    {
        $response = array(
            'print_statement' => $this->print_statement(),
            'print_result' => $this->print_result,
        );
        return response()->json($this->minimum_game_response($response), 200);
    }

    public function print_statement()
    {
        $currency = $this->currency;
        $balance = auth()->user()->$currency;
        $balance_formatted = number_format(($balance / 100), 2, '.', '');

        return [
                'debit' => $this->debit,
                'credit' => $this->credit,
                'currency' => $this->currency,
                'balance' => $balance,
                'formatted' => $balance_formatted,
                'player' => auth()->user()->id,
                'netto' => 0 - $this->debit + $this->credit,
                'outcome' => $this->outcome,
        ];
    }

    public function rng_to_symbol($input_number)
    {
        $this->rng = $this->rng . $input_number;
        if($input_number === 1) {
            return "A";
        }
        if($input_number === 2) {
            return "B";
        }
        if($input_number === 3) {
            return "C";
        }
        if($input_number === 4) {
            return "D";
        }
    }

    public function print_result()
    {
        $first_character = substr($this->rng, -3, 1);
        $second_character = substr($this->rng, -2, 1);
        $third_character = substr($this->rng, -1, 1);
        $this->outcome = "loss";

        if($first_character === $second_character) {
            if($first_character === $third_character) {
                $this->outcome = "win";
            }
        }

        return array(
            "game" => 'threeinarow',
            "rng" => $this->rng,
            "verbose" => $this->rng_verbose,
            "outcome" => $this->outcome,
        );
    }
}
