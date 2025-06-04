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
            'organizer_id' => Organizer::inRandomOrder()->first()->id,
            'event_address_id' => EventAddress::inRandomOrder()->first()->id,
            'name' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'is_active' => $this->faker->randomElement([true, false]),
            'capacity' => $this->faker->numberBetween(1, 100),
            'date' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}