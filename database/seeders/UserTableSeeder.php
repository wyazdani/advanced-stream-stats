<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::find(1);
        if (!$user)
        {
            User::create([
                'name' =>  'User',
                'email' =>  'user@example.com',
                'password'  =>  Hash::make('123456')
            ]);
        }
    }
}
