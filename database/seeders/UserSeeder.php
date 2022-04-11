<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Sam le',
            'email' => 'lesamcntta@gmail.com',
            'password' => Hash::make('lesam1234'),
            'api_token' => Str::random(60),
        ]);
    }
}