<?php

namespace Database\Factories;

use App\Models\Organization;
use App\Models\Position;
use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\History>
 */
class HistoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $class = fake()->randomElement([
            Unit::class,
            Position::class,
            Organization::class,
        ]);
        $historiable = $class::factory()->create();

        $startDate = fake()->dateTimeBetween('-1 year', 'now');
        $endDate = fake()->dateTimeBetween($startDate, '+1 year');

        return [
            'id' => fake()->uuid(),
            'meta' => [fake()->word => fake()->sentence],
            'historiable_id' => $historiable->id,
            'historiable_type' => get_class($historiable),
            'start_date' => $startDate,
            'end_date' => $endDate,
        ];
    }
}
