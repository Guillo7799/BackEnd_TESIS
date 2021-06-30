<?php

namespace Database\Factories;

use App\Models\Publication;
use Illuminate\Database\Eloquent\Factories\Factory;

class PublicationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Publication::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'career'   => $this->faker->sentence,
            'description'     => $this->faker->paragraph,
            'hours'      => $this->faker->sentence,
            'date'=> $this->faker->date,
        ];
    }
}
