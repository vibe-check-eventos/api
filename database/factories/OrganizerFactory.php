<?php

namespace Database\Factories;

use App\Models\Organizer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class OrganizerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Organizer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'organizer_type' => $this->faker->randomElement([0, 1]),
            'legal_name' => $this->faker->company,
            'cnpj' => $this->faker->numerify('###.###.###/####-##'),
            'cpf' => $this->faker->numerify('###.###.###-##'),
            'full_name' => $this->faker->word,
            'password' => $this->faker->password,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'created_at'=> $this->faker->date('Y-m-d H:i:s')
        ];
    }
}