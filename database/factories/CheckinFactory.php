<?php

namespace Database\Factories;

use App\Models\Checkin;
use App\Models\Registration;
use Illuminate\Database\Eloquent\Factories\Factory;

class CheckinFactory extends Factory
{
    protected $model = Checkin::class;

    public function definition()
    {
        return [
            'registration_id' => Registration::inRandomOrder()->first()->id,
            'created_at' => $this->faker->dateTimeBetween('-1 week', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('now', '+1 hour'),
        ];
    }
}