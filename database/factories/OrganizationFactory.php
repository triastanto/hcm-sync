<?php

namespace Database\Factories;

use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Organization>
 */
class OrganizationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->sentence(3),
        ];
    }

    /**
     * Configure the model factory for organizations with a parent.
     *
     * @return $this
     */
    public function withParent()
    {
        return $this->afterCreating(function (Organization $organization) {
            $parent = Organization::factory()->create();
            $organization->update(['parent_id' => $parent->id]);
        });
    }
}
