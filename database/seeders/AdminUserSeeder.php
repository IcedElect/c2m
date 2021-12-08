<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'phone' => '+79779486964',
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'password' => Hash::make('password'),
        ]);
    }
}
