<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserPermission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Gustavo Airton',
            'email' => 'gustavo@bexond.com',
            'password' => Hash::make('gustavomv2')
        ]);

        UserPermission::create([
            'user_id' => 1,
            'permission' => '*'
        ]);
    }
}
