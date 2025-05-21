<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\EventAddress;
use App\Models\Organizer;
use App\Models\Participant;
use App\Models\Registration;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        EventAddress::factory(10)->create();
        Participant::factory(10)->create();
        Organizer::factory(10)->create();
        Event::factory(10)->create();
        Registration::factory(10)->create();
    }
}