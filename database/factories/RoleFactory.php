<?php

namespace Database\Factories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;
use JetBrains\PhpStorm\ArrayShape;

class RoleFactory extends Factory
{
    protected $model = Role::class;

    #[ArrayShape(['name' => "string"])]
    public function definition(): array
    {
        return ['name' => $this->faker->name()];
    }
}
