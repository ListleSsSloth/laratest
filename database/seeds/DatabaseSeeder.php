<?php

use Illuminate\Database\Seeder;
//use App\User;

class DatabaseSeeder extends Seeder
{
    public function run()
    {     
        $this->call(RolesSeeder::class);
        $this->call(UsersSeeder::class);
    }
}
