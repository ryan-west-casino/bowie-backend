<?php
namespace App\Http\Controllers\Bowie\API;

use Illuminate\Http\Request;
use App\Models\User;
use Laravel\Lumen\Routing\Controller as BaseController;
use App\Http\Controllers\Bowie\API\ResponseTrait;

class PlayGame extends BaseController
{
    use ResponseTrait;

    public function __construct()
    {
        $this->middleware('auth:api');
        $this->gamekernel = new \App\Http\Controllers\Bowie\Games\GamesKernel();
        $this->list = $this->collection_loaded_games();
    }
    
    public function handle(Request $request)
    {
        $list = $this->list->where('id', $request->game)->first();
        return $list;
    }

    public function collection_loaded_games() {
            return collect($this->gamekernel->loaded_games());
    }

}

