<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Profile;
use App\Models\User;

class ProfileFactory extends Factory
{
    protected $model = Profile::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'postcode' => $this->faker->postcode(),
            'address' => $this->faker->address(),
            'building' => $this->faker->secondaryAddress(),
            'profile_image' => null,
        ];
    }
    /**
     * Define the model's default state.
     *
     * @return array
     */
}
