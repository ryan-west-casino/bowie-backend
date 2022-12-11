<?php
namespace App\Models;
use \Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Guzzle\Http\Client;

class InplayBalances extends Eloquent  {
    protected $table = 'inplay_balances';
    protected $timestamp = true;
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'secret',
        'currency',
        'inplay_balances',
    ];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
    public static function log_count() {
    }
    public function create(string $user_id, string $currency)
    {
            $get_user = User::where("id", $user_id)->first();
            if(!$get_user) {
                abort(400, "User with id ${user_id} could not be found.");
            }

            $search_user = $this->search($user_id, $currency);
            if($search_user !== NULL) {
                return $search_user;
            }
            $currency = strtoupper($currency);
            $url = 'https://scoobiedog.casinoman.app/api/mock/player/create?player_id='.$user_id.'&currency='.$currency;
            $create = Http::get($url);
            if($create->status() === 200) {
                $create = json_decode($create, true);
                $record = new InplayBalances();
                $record->id = Str::orderedUuid();
        		$record->user_id = $get_user->id;
        		$record->currency = $currency;
                $record->secret = $create["secret"];
        		$record->timestamps = true;
        		$record->save();
                return $record;
            } else {
                $error =  json_decode($create, true);
                save_log("Error creating mock profile", $error["reason"]);
                abort(400, $error["reason"]);
            }
    }
    public function search(string $user_id, string $currency)
    {
            $currency = strtoupper($currency);
            $record = new InplayBalances;
            $find = $record->where('user_id', $user_id)->where('currency', $currency)->first();
            return $find;
    }


    public function get_balance(string $user_id, string $currency)
    {
            $search_user = $this->search($user_id, $currency);
            if($search_user === NULL) {
                $create_profile = $this->create($user_id, $currency);
                $search_user = $this->search($user_id, $currency);
                if($search_user === NULL) {
                    abort(500, "User was not found, so we tried to create a new user which also failed (probably on third party side, check logs).");
                }
            }

            $get_balance = Http::get('https://scoobiedog.casinoman.app/api/mock/player/get_balance?player_id='.$user_id.'&currency='.$currency.'&secret='.$search_user->secret);
            if($get_balance->status() === 200) {
                $profile = json_decode($get_balance, true);
                return (int) $profile['balance'];
            } else {
                save_log("Error get_balance", json_encode($get_balance));
                abort(400, "Error get profile at thirdparty provider");
            }
    }

    public function set_balance(string $user_id, string $currency, $new_balance)
    {
            $search_user = $this->search($user_id, $currency);
            if($search_user === NULL) {
                $create_profile = $this->create($user_id, $currency);
                $search_user = $this->search($user_id, $currency);
                if($search_user === NULL) {
                    abort(500, "User was not found, so we tried to create a new user which also failed (probably on third party side, check logs).");
                }
            }
            $url = 'https://scoobiedog.casinoman.app/api/mock/player/set_balance?player_id='.$user_id.'&currency='.$currency.'&new_balance='.$new_balance.'&secret='.$search_user->secret;
            $set_balance = Http::get($url);
            if($set_balance->status() === 200) {
                return json_decode($set_balance, true);
            } else {
                $error = json_decode($set_balance, true);
                save_log("Error set_balance", $error['reason'] . '- URL: ' . $url);
                abort(400, "Error set balance at thirdparty provider");
            }
    }


    public function create_game_session(string $user_id, string $currency, string $game_id)
    {
            $search_user = $this->search($user_id, $currency);
            if($search_user === NULL) {
                $create_profile = $this->create($user_id, $currency);
                $search_user = $this->search($user_id, $currency);
                if($search_user === NULL) {
                    abort(500, "User was not found, so we tried to create a new user which also failed (probably on third party side, check logs).");
                }
            }
            $url = 'https://scoobiedog.casinoman.app/api/mock/player/get_game_url?game_id='.$game_id.'&player_id='.$user_id.'&currency='.$currency.'&secret='.$search_user->secret;
            $create_game = Http::get('https://scoobiedog.casinoman.app/api/mock/player/get_game_url?game_id='.$game_id.'&player_id='.$user_id.'&currency='.$currency.'&secret='.$search_user->secret);
            if($create_game->status() === 200) {
                $session = json_decode($create_game, true);
                return $session["message"]["session_url"];
            } else {
                save_log("Error create_game_session", $url);
                abort(400, "Error create_game at thirdparty provider");
            }
    }

}