<?php

use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Role::create(['name' => 'admin', 'description' => 'Администратор', 'protected' => 1]);
        App\Role::create(['name' => 'user', 'description' => 'Пользователь', 'protected' => 1]);
    }
}
