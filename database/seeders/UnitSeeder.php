<?php

namespace Database\Seeders;

use App\Models\Unit;
use App\Models\History;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        History::factory()
            ->count(4)
            ->state(new Sequence(
                ['meta' => ['name' => fake()->name], 'start_date' => '2020-01-10', 'end_date' => '2021-02-09'],
                ['meta' => ['name' => fake()->name], 'start_date' => '2021-02-10', 'end_date' => '2022-03-09'],
                ['meta' => ['name' => fake()->name], 'start_date' => '2022-03-10', 'end_date' => '2023-04-09'],
                ['meta' => ['name' => fake()->name], 'start_date' => '2023-04-10', 'end_date' => '9999-12-31'],
            ))->for(
                Unit::factory(),
                'historiable'
            )->create();

        History::factory()
            ->count(4)
            ->state(new Sequence(
                ['meta' => ['name' => fake()->name], 'start_date' => '2020-05-02', 'end_date' => '2021-06-01'],
                ['meta' => ['name' => fake()->name], 'start_date' => '2021-06-02', 'end_date' => '2022-07-01'],
                ['meta' => ['name' => fake()->name], 'start_date' => '2022-07-02', 'end_date' => '2023-08-01'],
                ['meta' => ['name' => fake()->name], 'start_date' => '2023-08-02', 'end_date' => '9999-12-31'],
            ))->for(
                Unit::factory(),
                'historiable'
            )->create();
    }
}
