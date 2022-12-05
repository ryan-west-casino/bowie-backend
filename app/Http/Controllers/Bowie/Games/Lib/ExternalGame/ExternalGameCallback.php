<?php

namespace App\Http\Controllers\Bowie\Games\Lib\ExternalGame;

use Illuminate\Http\Request;
use App\Models\User;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Bowie\API\ResponseTrait;
class ExternalGameCallback extends BaseController
{
    use ResponseTrait;

    public function __construct(Request $request)
    {
    }
    public function handle(Request $request)
    {
        

    }

}
