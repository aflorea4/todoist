<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(1)->withPersonalTeam()->create([
            'email' => 'alexandru.florea@staff.utcluj.ro',
            'password' => Hash::make('password')
        ]);
        \App\Models\User::factory(2)->withPersonalTeam()->create();
    }
}
