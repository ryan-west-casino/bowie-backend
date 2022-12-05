<?php

namespace App\Http\Controllers\Bowie\User;

use Illuminate\Http\Request;
use App\Models\User;
use Laravel\Lumen\Routing\Controller as BaseController;

class Balances extends BaseController
{
    public function print_all() {
        if(auth()->user()) {
            $data = [
            [
                    'id' => 'gbp',
                    'name' => 'Pound Sterling',
                    'fa' => 'faGbp',
                    'balance' => auth()->user()->gbp,
                    'formatted' => number_format((auth()->user()->gbp / 100), 2, '.', ''),
                    'type' => 'real',
                    'symbol' => '£',
            ],
            [
                    'id' => 'eur',
                    'name' => 'Euro',
                    'fa' => 'faEur',
                    'balance' => auth()->user()->eur,
                    'formatted' => number_format((auth()->user()->eur / 100), 2, '.', ''),
                    'type' => 'real',
                    'symbol' => '€',
            ],
            [
                    'id' => 'usd',
                    'name' => 'US Dollar',
                    'fa' => 'faUsd',
                    'balance' => auth()->user()->usd,
                    'formatted' => number_format((auth()->user()->usd / 100), 2, '.', ''),
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