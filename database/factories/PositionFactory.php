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
        $positions = ["Chief Executive Officer", "Vice President of Sales", "Vice President of Marketing", "Vice President of Finance", "Vice President of Operations", "Vice President of Human Resources", "Vice President of Technology", "Vice President of Business Development", "Vice President of Customer Service", "Vice President of Research and Development", "Director of Sales", "Director of Marketing", "Director of Finance", "Director of Operations", "Sales Manager", "Marketing Manager", "Finance Manager", "Operations Manager", "Human Resources Manager", "Technology Manager", "Business Development Manager", "Customer Service Manager", "Research and Development Manager", "Project Manager", "Product Manager", "Account Manager", "Client Relationship Manager", "IT Manager", "Compliance Manager", "Training Manager", "Development Manager", "Strategic Planning Manager", "Operations Coordinator", "Sales Coordinator", "Marketing Coordinator", "Finance Coordinator"];

        return [
            'title' => fake()->randomElement($positions),
        ];
    }
}
