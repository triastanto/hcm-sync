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
        Unit::factory()
            ->has(History::factory()
                ->count(4)
                ->state(new Sequence(
                    ['start_date' => '2020-01-10', 'end_date' => '2021-02-09'],
                    ['start_date' => '2021-01-10', 'end_date' => '2022-03-09'],
                    ['start_date' => '2022-01-10', 'end_date' => '2023-04-09'],
                    ['start_date' => '2023-01-10', 'end_date' => '9999-12-31'],
                )))
            ->create();
    }
}
