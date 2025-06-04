<?php

namespace Database\Factories;

use App\Models\QrCode;
use App\Models\Registration;
use Illuminate\Database\Eloquent\Factories\Factory;

class QrCodeFactory extends Factory
{
    protected $model = QrCode::class;

    public function definition(): array
    {
        return [
            'registration_id' => Registration::inRandomOrder()->first()->id,
            'qr_code_base64' => base64_encode($this->faker->uuid),
        ];
    }
}