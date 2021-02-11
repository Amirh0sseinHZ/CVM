<?php

namespace Database\Seeders;

use App\Models\Reservation;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()
            ->has(Reservation::factory()->count(5))
            ->create(['email' => 'spec1@nfq.lt']);
        User::factory()
            ->has(Reservation::factory()->count(3))
            ->create(['email' => 'spec2@nfq.lt']);
        User::factory()
            ->create(['email' => 'spec3@nfq.lt']);
    }
}
