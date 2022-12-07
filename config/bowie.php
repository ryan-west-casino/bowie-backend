<?php
return [
        'cli' => [
            'enabled' => env('BOWIE_CLI_ENABLED', false),
            'user_levels' => [
                    'player' => 5,
                    'operator' => 10,
                    'admin' => 69,
            ],
        ],
        'player_options' => [
            'start_currency' => 'usd',
            'start_balance' => 100000,
        ],
];
