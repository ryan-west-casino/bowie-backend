<?php
namespace App\Http\Controllers\Bowie\API;

use Illuminate\Http\Request;
use App\Models\User;
use Laravel\Lumen\Routing\Controller as BaseController;
use App\Http\Controllers\Bowie\API\ResponseTrait;

class InitExternalGame extends BaseController
{
    use ResponseTrait;

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function handle($slug, Request $request)
    {
        $init = new \App\Http\Controllers\Bowie\Games\Lib\ExternalGame\ExternalGameInit();
        return $init->handle($slug, 'USD', auth()->user()->id);
    }
}

