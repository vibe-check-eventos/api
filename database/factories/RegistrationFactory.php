<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\Participant;
use App\Models\Registration;
use Illuminate\Database\Eloquent\Factories\Factory;

class RegistrationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Registration::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'event_id' => Event::factory(),
            'participant_id' => Participant::factory(),
            'registration_date' => $this->faker->dateTimeThisYear(),
        ];
    }
}