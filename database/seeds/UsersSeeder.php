<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UsersSeeder extends Seeder
{
    public function run()
    {
        //add admin
        
        $data = array(
            'login' => 'admin',
            'password' => Hash::make(config('settings.site_admin_password')),
            'ldap' => 0,
            'protected' => 1,
            'is_root' => 1,
        );
        
        $user = App\User::create($data);
        // $roles = App\Role::all();
        // $current_date_time = Carbon::now()->toDateTimeString();

        
        // foreach ($roles as $role) {
        //     $user->roles()->attach($role->id, ['added_by' => 'seeder','added_on' => $current_date_time]);
        // }
    }
}
