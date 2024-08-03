<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Service;

class ServiceFactory extends Factory
{
    /**
     * O nome do modelo que a fábrica está associada.
     *
     * @var string
     */
    protected $model = Service::class;

    /**
     * Defina o estado padrão do modelo.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->word(),
            'type' => $this->faker->word(),
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'duration' => $this->faker->numberBetween(1, 120),
        ];
    }
}
