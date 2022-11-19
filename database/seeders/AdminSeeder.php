<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        User::create([
            'name' => 'admin',
            'email' => 'admin@mail.com',
            'password' => Hash::make("password"),
            'phone' => '0379600636',
            'is_admin' => true
        ]);
    }
}
