<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\AdSlot;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'is_admin' => true,
        ]);
        User::create([
            'name' => 'User',
            'email' => 'user@test.com',
            'password' => bcrypt('password'),
        ]);

        AdSlot::create([
            'name' => 'Banner Ad',
            'start_time' => Carbon::now()->addMinutes(5),
            'end_time' => Carbon::now()->addHours(1),
            'min_bid_price' => 10.00,
            'status' => 'upcoming',
        ]);
    }
}
