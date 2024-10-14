<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Position>
 */
class PositionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'is_structural' => true,
            'title' => fake()->jobTitle,
        ];
    }

    public function structural(): Factory
    {
        $structuralPositions = [
            'Sales Manager', 'Marketing Manager', 'Finance Manager', 'Operations Manager', 'Human Resources Manager', 'Technology Manager', 'Business Development Manager', 'Customer Service Manager', 'Research and Development Manager', 'Project Manager', 'Product Manager', 'Account Manager', 'Client Relationship Manager', 'IT Manager', 'Compliance Manager', 'Training Manager', 'Development Manager', 'Strategic Planning Manager'
        ];

        return $this->state(function (array $attributes) use ($structuralPositions) {
            return [
                'is_structural' => true,
                'title' => fake()->randomElement($structuralPositions),
            ];
        });
    }

    public function nonStructural(): Factory
    {
        $nonStructuralPositions = ['Operations Coordinator', 'Sales Coordinator', 'Marketing Coordinator', 'Finance Coordinator', 'Staff'];

        return $this->state(function (array $attributes) use ($nonStructuralPositions) {
            return [
                'is_structural' => false,
                'title' => fake()->randomElement($nonStructuralPositions),
            ];
        });
    }
}
