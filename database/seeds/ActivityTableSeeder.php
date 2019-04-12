<?php

use Illuminate\Database\Seeder;

class ActivityTableSeeder extends Seeder
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
                'name' => 'Adventure Racing',
            ],
            [
                'name' => 'Basketball',
            ],
            [
                'name' => 'BMX',
            ],
            [
                'name' => 'Camping',
            ],
            [
                'name' => 'Canoeing',
            ],
            [
                'name' => 'Cornhole',
            ],
            [
                'name' => 'Cross Fit',
            ],
            [
                'name' => 'Cross-Country Skiing',
            ],
            [
                'name' => 'Cycling',
            ],
            [
                'name' => 'Disc Golf',
            ],
            [
                'name' => 'Fishing',
            ],
            [
                'name' => 'Golf',
            ],
            [
                'name' => 'Hiking',
            ],
            [
                'name' => 'Hunting',
            ],
            [
                'name' => 'Ice Skating',
            ],
            [
                'name' => 'Kayaking',
            ],
            [
                'name' => 'Kite Surfing',
            ],
            [
                'name' => 'Kiteboarding',
            ],
            [
                'name' => 'Martial Arts',
            ],
            [
                'name' => 'Motocross',
            ],
            [
                'name' => 'Motorsports Racing',
            ],
            [
                'name' => 'Mountain Biking',
            ],
            [
                'name' => 'Mountaineering',
            ],
            [
                'name' => 'Paddleboarding',
            ],
            [
                'name' => 'Parkour',
            ],
            [
                'name' => 'Pickleball',
            ],
            [
                'name' => 'Racquetball',
            ],
            [
                'name' => 'Rafting',
            ],
            [
                'name' => 'Rock Climbing',
            ],
            [
                'name' => 'Running',
            ],
            [
                'name' => 'Sailing',
            ],
            [
                'name' => 'Skateboarding',
            ],
            [
                'name' => 'Skating',
            ],
            [
                'name' => 'Skiing',
            ],
            [
                'name' => 'Skydiving',
            ],
            [
                'name' => 'Slacklining',
            ],
            [
                'name' => 'Snowboarding',
            ],
            [
                'name' => 'Surfing',
            ],
            [
                'name' => 'Tennis',
            ],
            [
                'name' => 'Triathlon',
            ],
            [
                'name' => 'Ultimate Frisbee',
            ],
            [
                'name' => 'Wakeboarding',
            ],
            [
                'name' => 'Windsurfing',
            ],
            [
                'name' => 'Yoga',
            ]
        ]);
    }
}
