<?php

namespace Database\Factories;

use App\Models\Reservation;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ReservationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Reservation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'specialist_id' => function() {
                return \App\Models\User::factory()->create()->id;
            },
            'customer_id' => Str::random(40),
            'status' => $this->faker->randomElement([-1, 0, 1, 2]),
        ];
    }
}
