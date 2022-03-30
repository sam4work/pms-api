<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//         \App\Models\User::factory(10)->create();
        DB::table('users')->insert([
            'name' => "Super",
            'email' => "super@super.com",
            'email_verified_at' => now(),
            'password' => Hash::make("super@super.com"), // password
            'remember_token' => Str::random(10),
        ]);
//         \App\Models\Customer::factory(15)->create();
         \App\Models\GhanaCard::factory(20)->create();
    }
}
