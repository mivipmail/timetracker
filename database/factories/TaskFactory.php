<?php

namespace Database\Factories;

use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;


class TaskFactory extends Factory
{
    public function definition()
    {
        $projects = Project::all();

        $startedAtSubDays = rand(0, 2);

        return [
            'project_id' => $projects->random()->id,
            'title' => 'Задача ' . fake()->name(),
            'description' => $this->faker->text(700),
            'created_at' => Carbon::now()->subDays(rand(2, 3)),
            'started_at' => $startedAtSubDays > 1 ? Carbon::now()->subDays($startedAtSubDays) : null,
            'time' => $startedAtSubDays > 1 ? rand(0, 28800) : 0,
        ];
    }
}
