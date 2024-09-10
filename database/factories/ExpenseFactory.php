<?php

namespace Database\Factories;

use App\Models\Master\Status;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExpenseFactory extends Factory
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
            'amount' => random_int(100000, 1000000),
            'status_id' => Status::inRandomOrder()->first()->id
        ];
    }
}
