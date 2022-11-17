<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = array(
            'email'    => 'manager@pestademokrasi2021.skanza',
            'name'     => 'ADMINISTRATOR',
            'level'    => 'admin',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'created_at'        => now()
        );

        \App\Models\User::insert($admin);
    }
}
