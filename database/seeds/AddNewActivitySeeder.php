<?php

use Illuminate\Database\Seeder;

class AddNewActivitySeeder extends Seeder
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
                'name' => 'Aviation',
            ],
            [
                'name' => 'Base Jumping',
            ],
            [
                'name' => 'Boxing',
            ],
            [
                'name' => 'Indoor Skydiving',
            ],
            [
                'name' => 'Paragliding',
            ],
            [
                'name' => 'Softball',
            ]
        ]);
    }
}
