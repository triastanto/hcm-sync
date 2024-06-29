<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Unit>
 */
class UnitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $units = ["Finance Department", "Human Resources Department", "Marketing Department", "Sales Department", "Operations Department", "Technology Department", "Customer Service Department", "Research and Development Department", "Legal Department", "Compliance Department", "Strategy Department", "Product Development Department", "Business Development Department", "Corporate Communications Department", "Supply Chain Department", "Quality Assurance Department", "Facilities Management Department", "Risk Management Department", "Procurement Department", "Project Management Office", "Information Technology Department", "Engineering Department", "Production Department", "Logistics Department", "Security Department", "Training and Development Department", "Health and Safety Department", "Public Relations Department", "Investor Relations Department", "Corporate Social Responsibility Department", "Internal Audit Department", "Data Analytics Department", "Digital Marketing Department", "E-commerce Department", "Talent Acquisition Department", "Performance Management Department", "Compensation and Benefits Department", "Employee Relations Department", "Organizational Development Department", "Customer Experience Department", "Innovation Department", "Sustainability Department", "Legal Affairs Department", "Government Affairs Department", "Community Outreach Department", "Media Relations Department", "Investor Relations Department", "Diversity and Inclusion Department", "Event Planning Department", "Content Development Department", "Social Media Department"];

        return [
            'name' => fake()->randomElement($units),
        ];
    }
}
