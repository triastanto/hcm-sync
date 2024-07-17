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
        $this->call(UserSeeder::class);

        $organizations = Organization::factory()
            ->has(Unit::factory()
                ->has(Position::factory()
                    ->has(Employee::factory()->count(fake()->numberBetween(1, 3)))
                    ->count(fake()->numberBetween(1, 3)))
                ->count(fake()->numberBetween(1, 3)))
            ->count(12)
            ->create();

        // Set parent-child relationship for organizations
        $organizations->each(function ($organization) use ($organizations) {
            $potentialParents = $organizations->where('id', '!=', $organization->id);
            if ($potentialParents->isNotEmpty()) {
                $organization->disableRevisionField('parent_id');
                $organization->update(['parent_id' => $potentialParents->random()->id]);
            }
        });

        // Set parent-child relationship for units within each organization
        foreach ($organizations as $organization) {
            $units = $organization->units;
            $units->each(function ($unit) use ($units) {
                $potentialParents = $units->where('id', '!=', $unit->id);
                if ($potentialParents->isNotEmpty()) {
                    $unit->disableRevisionField('parent_id');
                    $unit->update(['parent_id' => $potentialParents->random()->id]);
                }
            });
        }
    }
}
