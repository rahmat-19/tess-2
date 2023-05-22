<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EventUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $userIds = [1,2,3];

        return [
            'nama' => $this->faker->name,
            'tanggal' => $this->faker->date,
            'deskripsi' => $this->faker->sentence,
            'user_id' => $this->faker->randomElement($userIds),
        ];
    }
}
