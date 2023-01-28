<?php

namespace Database\Factories;

use App\Enums\IdentityTypeEnum;
use App\Models\IdentityDetails;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\IdentityDetails>
 */
class IdentityDetailsFactory extends Factory
{
    protected $model = IdentityDetails::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'type' => $this->faker->randomElement(IdentityTypeEnum::getValues()),
            'images' => json_encode(['image1.jpg', 'image2.jpg']),
            'expires_at' => $this->faker->date(),
            'number' => $this->faker->randomNumber(8),
            'user_id' => User::all()->random()->id,
            'archive' => 0,
        ];
    }
}
