<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ApproverFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $fake = $this->withFaker();

        return [
            'name' => $fake->name(),
        ];
    }
}
