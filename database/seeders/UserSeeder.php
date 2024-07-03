<?php

namespace Database\Seeders;

use App\Models\User;
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
    }
}
