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
        return [
            'name' => fake()->company,
        ];
    }

    private function randomState(array $names): Factory
    {
        return $this->state(function () use ($names) {
            return [
                'name' => fake()->randomElement($names),
            ];
        });
    }

    public function directorate(): Factory
    {
        $directorates = [
            'Main Directorate',
            'Directorate of Finance',
            'Directorate of Human Resources',
            'Directorate of Business and Development',
            'Directorate of Operations',
        ];

        return $this->randomState($directorates);
    }

    public function division(): Factory
    {
        $divisions = [
            'Division of Financial Planning',
            'Division of Payroll',
            'Division of Recruitment',
            'Division of Employee Relations',
            'Division of Software Development',
            'Division of Network Administration',
            'Division of Digital Marketing',
            'Division of Public Relations',
            'Division of Product Research',
            'Division of Process Improvement',
            'Division of Logistics',
            'Division of Customer Support',
        ];

        return $this->randomState($divisions);
    }

    public function department(): Factory
    {
        $departments = [
            'Department of Budgeting and Forecasting',
            'Department of Accounts Payable',
            'Department of Accounts Receivable',
            'Department of Talent Acquisition',
            'Department of Employee Benefits',
            'Department of IT Support',
            'Department of Software Engineering',
            'Department of Network Security',
            'Department of Social Media',
            'Department of Content Creation',
            'Department of Market Research',
        ];

        return $this->randomState($departments);
    }
}
