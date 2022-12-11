<?php
namespace App\Http\Controllers\Bowie\API;

use Illuminate\Http\Request;
use App\Models\User;
use Laravel\Lumen\Routing\Controller as BaseController;
use App\Http\Controllers\Bowie\API\ResponseTrait;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Bowie\Games\GamesKernel;

class InitGame extends BaseController
{
    use ResponseTrait;

    public function __construct(Request $request)
    {
        $this->middleware('auth:api');
        $this->games_lib_namespace = "\App\Http\Controllers\Bowie\Games\Lib";
        $this->gamekernel = new GamesKernel();
        $this->meta_game = $this->gamekernel->game_byId($request->game);
    }

    public function load_gameclass($class)
    {
        return new ($this->games_lib_namespace . $class)();
    }

    public function handle(Request $request)
    {
        $this->validate($request, [
                'game' => 'required|string|min:2|max:255',
                'currency' => 'required|string|min:1|max:5',
        ]);
        $init_meta = $this->init_meta();
        $data = $this->extended_response([
            'game' => $this->meta_game,
            'currency' => $request->currency,
            'init_meta' => $init_meta,
            'extra_init_function' => $this->extra_init_function($request->game, $init_meta, $request->currency),
        ]);
    

        return response()->json($data, 200);
    }

    public function init_meta()
    {
        try {
        if(!isset($this->meta_game["class"]["meta"])) {
            return "[]";
        }
        return $this->load_gameclass($this->meta_game["class"]["meta"])->init_meta();
        } catch(\Exception $e) {
            return [
                    'error' => $e->getMessage()
                ];
        }
    }

    public function extra_init_function($game, $data, $currency)
    {
        try {
        if(!isset($this->meta_game["class"]["init"])) {
            return "[]";
        }
        return $this->load_gameclass($this->meta_game["class"]["init"])->handle($game, $currency);
        } catch(\Exception $e) {
            return [
                    'error' => $e->getMessage()
                ];
        }
    }
}

