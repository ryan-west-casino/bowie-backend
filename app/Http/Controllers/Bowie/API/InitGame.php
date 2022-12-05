<?php
namespace App\Http\Controllers\Bowie\API;

use Illuminate\Http\Request;
use App\Models\User;
use Laravel\Lumen\Routing\Controller as BaseController;
use App\Http\Controllers\Bowie\API\ResponseTrait;

class InitGame extends BaseController
{
    use ResponseTrait;

    public function __construct()
    {
        $this->middleware('auth:api');
    }

public function handle(Request $request)
{
    $user = auth()->user();
    $data = [
          'usd' => $user->usd,
          'eur' => $user->eur,
          'gbp' => $user->gbp,
        ];
    return $data;
}
}

