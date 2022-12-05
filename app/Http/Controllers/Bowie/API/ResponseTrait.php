<?php
namespace App\Http\Controllers\Bowie\API;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Crypt;
use Laravel\Lumen\Routing\Controller as BaseController;
use App\Http\Controllers\Bowie\User\Balances;

trait ResponseTrait
{
    public function extended_response($data): array
    {
        $this->balances = new Balances();
            $data = [
                    'code' => 200,
                    'status' => 'success',
                    'data' => $data,
                    'user' => $this->user_builder(),
                    'balances' => $this->balances->print_all(),
                    'meta' => $this->meta_builder(),
            ];
            return $data;
    }

    public function minimum_game_response($data): array
    {
        $data = [
            'code' => 200,
            'status' => 'success',
            'user' => $this->user_builder(),
            'data' => $data,
        ];
        return $data;
    }

    public function meta_builder()
    {
        $data = [
                'name' => 'Generic Casino',
        ];
        return $data;
    }

    public function user_builder()
    {
        if(auth()->user()) {
            $user = auth()->user();
            return array(
                "profile" => $user,
                "balance" => array(
                    "usd" => array("integer" => $user->usd, "formatted" => number_format((auth()->user()->usd / 100), 2, '.', '')),
                    "eur" => array("integer" => $user->eur, "formatted" => number_format((auth()->user()->eur / 100), 2, '.', '')),
                    "gbp" => array("integer" => $user->gbp, "formatted" => number_format((auth()->user()->gbp / 100), 2, '.', '')),
                )
            );
        } else {
            return '[]';
        }
    }

    public function balances_builder()
    {

    }

}