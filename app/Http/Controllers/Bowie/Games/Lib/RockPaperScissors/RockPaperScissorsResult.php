<?php

namespace App\Http\Controllers\Bowie\Games\Lib\RockPaperScissors;

use Illuminate\Http\Request;
use App\Models\User;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Bowie\API\ResponseTrait;
use App\Http\Controllers\Bowie\Games\GamesKernel;
class RockPaperScissorsResult extends BaseController
{
    use ResponseTrait;

    public function __construct(Request $request)
    {
        $this->middleware('auth:api');
        $this->allowed_choices = [
                'paper', 'rock', 'scissors'
        ];
        $this->gamekernel = new GamesKernel();
        $this->rng_verbose = NULL;
        $this->debit = (int) $request->bet;
        $this->credit = 0;
        $this->choice = $request->choice;
        $this->rng = rand(1, 3);
        $this->print_result = $this->print_result();
        $this->currency = strtolower($request->currency);
    }

    public function validate_choice()
    {
        if(!in_array($this->choice, $this->allowed_choices)) {
            abort(500, 'Choice is not allowed. Only paper rock or scissors.');
        }
    }

    public function handle(Request $request)
    {
        $this->validate($request, [
                'bet' => 'required|integer|min:1|max:1000000000',
                'choice' => 'required|string|min:2|max:255',
                'currency' => 'required|string|min:1|max:5',
        ]);
        $this->validate_choice();
        $bet = $this->debit;
        $result = $this->rng_verbose;
        $choice = $this->choice;
        $currency = $this->currency;

        if($result === 'rock') {
            if($choice === 'paper') { // win
                $this->credit = ($bet * 2);
                $this->gamekernel->process_game($bet, $this->credit, $currency);
                $this->outcome = 'win';
            } elseif($choice === 'scissors') { //loss
                $this->gamekernel->process_game($bet, 0, $currency);
                $this->outcome = 'loss';
            } else { // draw
                $this->credit = $bet;
                $this->gamekernel->process_game($bet, $this->credit, $currency);
                $this->outcome = 'draw';
            }
        }

        if($result === 'scissors') {
            if($choice === 'paper') { // win
                $this->credit = ($bet * 2);
                $this->gamekernel->process_game($bet, $this->credit, $currency);
                $this->outcome = 'win';
            } elseif($choice === 'rock') { //loss
                $this->gamekernel->process_game($bet, 0, $currency);
                $this->outcome = 'loss';
            } else { // draw
                $this->credit = $bet;
                $this->gamekernel->process_game($bet, $this->credit, $currency);
                $this->outcome = 'draw';
            }
        }

        if($result === 'paper') {
            if($choice === 'scissors') { // win
                $this->credit = ($bet * 2);
                $this->gamekernel->process_game($bet, $this->credit, $currency);
                $this->outcome = 'win';
            } elseif($choice === 'rock') { //loss
                $this->gamekernel->process_game($bet, 0, $currency);
                $this->outcome = 'loss';
            } else { // draw
                $this->credit = $bet;
                $this->gamekernel->process_game($bet, $this->credit, $currency);
                $this->outcome = 'draw';
            }
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

    public function print_result()
    {
        if($this->rng === 1) {
            $this->rng_verbose = "paper";
        }
        if($this->rng === 2) {
            $this->rng_verbose = "rock";
        }
        if($this->rng === 3) {
            $this->rng_verbose = "scissors";
        }
        if($this->rng_verbose === NULL) {
            abort(400, "No selectable verbose outcome for: {$this->rng}");
        }
        return array(
            "game" => 'rockpaperscissors',
            "rng" => $this->rng,
            "verbose" => $this->rng_verbose,
            "choice" => $this->choice,
        );
    }
}
