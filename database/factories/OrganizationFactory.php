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
        $organizations = ["Global Solutions Inc.", "Apex Innovations", "Evergreen Enterprises", "Nexus Technologies", "Quantum Dynamics", "Horizon Ventures", "Stellar Networks", "BlueSky Logistics", "Infinity Systems", "Zenith Industries", "SolarWave Corp.", "Prime Strategies",];

        return [
            'name' => fake()->randomElement($organizations),
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
