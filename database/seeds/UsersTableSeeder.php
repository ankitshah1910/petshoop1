<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Role;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        DB::table('role_user')->truncate();

        $adminRole=Role::where('name','admin')->first();
        $userRole=Role::where('name','user')->first();


        $admin=User::create([
            'name'=>'Admin user',
            'email'=>'admin@demo.com',
            'ph_number'=>'+91 9876435787',
            'shop_name'=>'',
            'password'=>Hash::make('password')
        ]);

        $user=User::create([
            'name'=>'shop general user',
            'email'=>'user@user.com',
            'ph_number'=>'+91 9876435787',
            'shop_name'=>'My first shop',
            'password'=>Hash::make('password')
        ]);

        $admin->roles()->attach($adminRole);
        $user->roles()->attach($userRole);
    }
}
