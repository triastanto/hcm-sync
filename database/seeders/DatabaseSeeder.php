<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Organization;
use App\Models\Position;
use App\Models\Unit;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Organization::factory()
            ->has(Unit::factory()
                ->has(Position::factory()
                    ->has(Employee::factory()->count(fake()->numberBetween(1, 1)))
                    ->count(fake()->numberBetween(1, 1)))
                ->count(fake()->numberBetween(1, 1)))
            ->count(100)
            ->create();
    }
}
