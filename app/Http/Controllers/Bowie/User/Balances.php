<?php

namespace App\Http\Controllers\Bowie\User;

use Illuminate\Http\Request;
use App\Models\User;
use Laravel\Lumen\Routing\Controller as BaseController;
use App\Models\InplayBalances;

class Balances extends BaseController
{

    public function __construct()
    {
        $this->inplay_usd = 0;
        $this->inplay_eur = 0;
        $this->inplay_gbp = 0;
    }


    public function inplay_balance_builder() {
            $inplay = new InplayBalances;
            try {
                $this->inplay_usd = $inplay->get_balance(auth()->user()->id, "USD");
                $this->inplay_eur = $inplay->get_balance(auth()->user()->id, "EUR");
                $this->inplay_gbp = $inplay->get_balance(auth()->user()->id, "GBP");
            } catch(\Exception $e) {
                    save_log("Error retrieving inplay balances", $e->getMessage() . 'at line' . $e->getLine());
            }
    }


    public function print_all() {
        if(auth()->user()) {
            $this->inplay_balance_builder();
            $data = [
            [
                    'id' => 'gbp',
                    'name' => 'Pound Sterling',
                    'fa' => 'faGbp',
                    'balance' => auth()->user()->gbp,
                    'formatted' => number_format((auth()->user()->gbp / 100), 2, '.', ''),
                    'inplay' => $this->inplay_gbp,
                    'inplay_formatted' => number_format(($this->inplay_gbp / 100), 2, '.', ''),
                    'type' => 'real',
                    'symbol' => '£',
            ],

            [
                    'id' => 'eur',
                    'name' => 'Euro',
                    'fa' => 'faEur',
                    'balance' => auth()->user()->eur,
                    'formatted' => number_format((auth()->user()->eur / 100), 2, '.', ''),
                    'inplay' => $this->inplay_eur,
                    'inplay_formatted' => number_format(($this->inplay_eur / 100), 2, '.', ''),
                    'type' => 'real',
                    'symbol' => '€',
            ],
            [
                    'id' => 'usd',
                    'name' => 'US Dollar',
                    'fa' => 'faUsd',
                    'balance' => auth()->user()->usd,
                    'formatted' => number_format((auth()->user()->usd / 100), 2, '.', ''),
                    'inplay' => $this->inplay_usd,
                    'inplay_formatted' => number_format(($this->inplay_usd / 100), 2, '.', ''),
                    'type' => 'real',
                    'symbol' => '$',
            ],
            ];
        } else {
            $data = [
            [
                    'id' => 'gbp',
                    'fa' => 'faGbp',
                    'user_balance' => 0,
                    'user_balance_formatted' => number_format(0, 2, '.', ''),
                    'type' => 'real',
                    'symbol' => '£',
                    'decimal' => 2,
                    'default' => false,
                    'name' => 'Pound Sterling'
            ],
            [
                    'id' => 'eur',
                    'fa' => 'faEur',
                    'user_balance' => auth()->user()->eur,
                    'user_balance_formatted' => number_format(0, 2, '.', ''),
                    'type' => 'real',
                    'symbol' => '€',
                    'decimal' => 2,
                    'default' => false,
                    'name' => 'Euro'
            ],
            [
                    'id' => 'usd',
                    'fa' => 'faUsd',
                    'user_balance' => auth()->user()->usd,
                    'user_balance_formatted' => number_format(0, 2, '.', ''),
                    'type' => 'real',
                    'symbol' => '$',
                    'default' => true,
                    'decimal' => 2,
                    'name' => 'US Dollar'
            ],
            ];
        }
        return $data;
    }
}