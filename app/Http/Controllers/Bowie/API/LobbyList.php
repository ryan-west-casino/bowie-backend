<?php
namespace App\Http\Controllers\Bowie\API;

use Illuminate\Http\Request;
use App\Models\User;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Bowie\API\ResponseTrait;

class LobbyList extends BaseController
{
    use ResponseTrait;

    public function __construct()
    {
        $this->middleware('auth:api');
        $this->gamekernel = new \App\Http\Controllers\Bowie\Games\GamesKernel();
    }

    public function handle(Request $request)
    {
        $game_data = $this->extended_response($this->gamekernel->loaded_games());
        return response()->json($game_data, 200);
    }
}

