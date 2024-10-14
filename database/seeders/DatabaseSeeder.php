<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Organization;
use App\Models\Position;
use App\Models\Subgroup;
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

        /**
         * 4 organizations with 1 as the root
         * Each organization has 3 level units from directorate, division, to department
         * Each organization has 2 directorate where each directorate has 2 division where each division has 2 department
         * Each directorate has 1 structural position and 1 employee also 1 non structural position and 1 employee
         * Each division & department has 1 structural position and 1 employee
         * Each division & department has 2 non structural position and each position has 2 employees
         */

        // Create 4 organizations where 1 is the root
        $organizations = Organization::factory()->count(4)->create();

        // Manually set the parent_id for the non-root organizations
        $rootOrganization = $organizations->first();
        $organizations->slice(1)->each(function ($organization) use ($rootOrganization) {
            $organization->parent_id = $rootOrganization->id;
            $organization->save();
        });

        // Create 3 level units with its positions and employees
        $organizations->each(function ($organization) {
            // Create 2 'directorate level' units for each organization
            $directorates = Unit::factory()->directorate()->count(2)->create(['organization_id' => $organization->id]);

            $directorates->each(function ($directorate) use ($organization) {

                // Create positions and its employees for each directorate
                $this->createPositionsAndEmployees($directorate->id, $organization->id, 1);

                // Create 2 'division level' units for each directorate
                $divisions = Unit::factory()->division()->count(2)->create(['organization_id' => $organization->id]);

                $divisions->each(function ($division) use ($organization, $directorate) {
                    // Set division's parent to previous directorate
                    $division->parent_id = $directorate->id;
                    $division->save();

                    // Create positions and its employees for each division
                    $this->createPositionsAndEmployees($division->id, $organization->id, 2);

                    // Create 2 'department level' units for each division
                    $departments = Unit::factory()->department()->count(2)->create(['organization_id' => $organization->id]);

                    $departments->each(function ($department) use ($division, $organization) {
                        // Set department's parent to previous division
                        $department->parent_id = $division->id;
                        $department->save();

                        // Create positions and its employees for each department
                        $this->createPositionsAndEmployees($department->id, $organization->id, 2);
                    });
                });
            });
        });
    }

    private function createStructuralPositionAndEmployee($unit_id, $organization_id): void
    {
        // Create structural subgroups for the directorate
        $subgroup = Subgroup::factory()->structural()->create(['organization_id' => $organization_id]);

        // Create 1 'structural' position for each department
        $structural = Position::factory()->structural()->create([
            'unit_id' => $unit_id,
            'subgroup_id' => $subgroup->id,
        ]);

        // Create 1 employee for 'structural' position
        Employee::factory()->create(['position_id' => $structural->id]);
    }

    private function createNonStructuralPositionsAndEmployees($unit_id, $organization_id, $ns_count): void
    {
        // Create non structural subgroups for the directorate
        $subgroup = Subgroup::factory()->nonStructural()->create(['organization_id' => $organization_id]);

        // Create 3 'non structural' positions for each department
        $nonStructurals = Position::factory()->nonStructural()->create([
            'unit_id' => $unit_id,
            'subgroup_id' => $subgroup->id,
        ]);

        // Create 1 to 3 employees for each non-structural position
        $nonStructurals->each(function ($position) use ($ns_count) {
            Employee::factory()->count($ns_count)->create(['position_id' => $position->id]);
        });
    }

    private function createPositionsAndEmployees($unit_id, $organization_id, $ns_count): void
    {
        $this->createStructuralPositionAndEmployee($unit_id, $organization_id);
        $this->createNonStructuralPositionsAndEmployees($unit_id, $organization_id, $ns_count);
    }
}
