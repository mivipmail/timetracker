<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{

    protected static $i = 0;

    public function definition()
    {
        return [
            'title' => 'Проект ' . fake()->name(),
            'description' => $this->faker->text(500),
            'created_at' => Carbon::now()->subDays(rand(3, 5)),
        ];
    }
}
