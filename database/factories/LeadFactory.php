<?php

declare(strict_types=1);

namespace Agenciafmd\Leads\Database\Factories;

use Agenciafmd\Leads\Models\Lead;
use Illuminate\Database\Eloquent\Factories\Factory;

final class LeadFactory extends Factory
{
    protected $model = Lead::class;

    public function definition(): array
    {
        return [
            'is_active' => fake()->boolean(),
            'source' => fake()->word(),
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'description' => fake()->paragraph(),
        ];
    }
}
