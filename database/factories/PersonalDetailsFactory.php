<?php

namespace Database\Factories;

use App\Models\Location;
use App\Models\PersonalDetails;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PersonalDetailsFactory extends Factory
{
    protected $model = PersonalDetails::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'location_id' => Location::all()->random()->id,
            'father_name' => $this->faker->name('male'),
            'mother_name' => $this->faker->name('female'),
            'phone' => $this->faker->unique()->phoneNumber,
            'date_of_birth' => $this->faker->dateTimeBetween('-60 years', '-18 years'),
            'about' => $this->faker->text(200),
            'gender' => $this->faker->randomElement(['male', 'female', 'other']),
            'user_id' => User::all()->random()->id,
            'archive' => $this->faker->randomElement([0, 1]),
        ];
    }
}
