<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeed extends Seeder
{
    /**
    * Run the database seeds.
    *
    * @return void
    */
public function run()
{
        $this->seed_user("bowie_cli_admin", "bowie_cli_admin@casinoman.app", (config('bowie.cli.user_levels.admin') ?? 69), "bowieCliPasswordAdmin");
        $this->seed_user("bowie_cli_operator", "bowie_cli_operator@casinoman.app", (config('bowie.cli.user_levels.operator') ?? 5), "bowieCliPasswordOperator");
        $this->seed_user("bowie_cli_player", "bowie_cli_player@casinoman.app", (config('bowie.cli.user_levels.player') ?? 5), "bowieCliPasswordPlayer");
        $this->seed_user("bowie_web_player", "bowie_web_player@casinoman.app", 0, "bowieWebPlayer");

}

public function seed_user($name, $email, $level, $password)
{
    try {
        $user = User::create([
                'name' => 'bowie_cli',
                'email' => $email,
                'level' => $level,
                'password' => Hash::make($password),
        ]);
        echo " > created {$name} with level {$level} and password {$password} \n";
    } catch(\Exception $e) {
        echo "\n\n Error seeding {$name}: \n";
        echo $e->getMessage() . "\n \n";
    }
}

}
