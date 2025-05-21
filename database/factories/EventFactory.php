<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\Organizer;
use App\Models\EventAddress;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Event::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'organizer_id' => Organizer::factory(),
            'event_address_id' => EventAddress::factory(),
            'name' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'date' => $this->faker->dateTimeBetween('+1 week', '+1 year')->format('Y-m-d H:i:s'),
            'price' => $this->faker->randomFloat(2, 0, 1000),
            'status' => $this->faker->randomElement(['scheduled', 'cancelled', 'completed']),
        ];
    }
}