<?php

namespace Database\Seeders;

use App\Models\History;
use App\Models\Position;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        History::factory()
            ->count(4)
            ->state(new Sequence(
                ['start_date' => '2020-01-10', 'end_date' => '2021-02-09'],
                ['start_date' => '2021-02-10', 'end_date' => '2022-03-09'],
                ['start_date' => '2022-03-10', 'end_date' => '2023-04-09'],
                ['start_date' => '2023-04-10', 'end_date' => '9999-12-31'],
            ))->for(
                Position::factory(),
                'historiable'
            )->create();

        History::factory()
            ->count(4)
            ->state(new Sequence(
                ['start_date' => '2020-05-02', 'end_date' => '2021-06-01'],
                ['start_date' => '2021-06-02', 'end_date' => '2022-07-01'],
                ['start_date' => '2022-07-02', 'end_date' => '2023-08-01'],
                ['start_date' => '2023-08-02', 'end_date' => '9999-12-31'],
            ))->for(
                Position::factory(),
                'historiable'
            )->create();
    }
}
