<?php

use Illuminate\Database\Seeder;

class NewActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('activity')->insert([
            [
                'name' => '4X4',
            ],
            [
                'name' => 'Backpacking',
            ],
            [
                'name' => 'Highpointing',
            ],
            [
                'name' => 'Ice Climbing',
            ],
            [
                'name' => 'Marksmanship',
            ],
            [
                'name' => 'SCUBA Diving',
            ],
            [
                'name' => 'Snorkeling',
            ],
            [
                'name' => 'Swimming',
            ],
            [
                'name' => 'Wakesurfing',
            ]
        ]);
    }
}
