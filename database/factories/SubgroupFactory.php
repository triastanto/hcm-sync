<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subgroup>
 */
class SubgroupFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->randomLetter,
        ];
    }

    public function structural() : Factory
    {
        $structuralGroups = ['AS', 'BS', 'CS', 'DS', 'ES'];
        return $this->state(function (array $attributes) use ($structuralGroups){
            return [
                'name' => fake()->randomElement($structuralGroups)
            ];
        });
    }

    public function nonStructural() : Factory
    {
        $nonStructuralGroups = ['AF', 'BF', 'CF', 'DF', 'EF', 'F'];

        return $this->state(function (array $attributes) use ($nonStructuralGroups){
            return [
                'name' => fake()->randomElement($nonStructuralGroups)
            ];
        });
    }
}
