<?php

use Illuminate\Database\Seeder;

class GroupSettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('group_setting')->insert([
            [
                'name' => 'Allow members to invite users',
                'parameter' => 'INVITE_USERS',
                'type' => 1,
                'sort_order' => 1
            ],
            [
                'name' => 'Request to join',
                'parameter' => 'REQUEST_TO_JOIN',
                'type' => 1,
                'sort_order' => 2

            ],
            [
                'name' => 'Keep posts private to members',
                'parameter' => 'PRIVATE_POSTS',
                'type' => 2,
                'sort_order' => 3

            ],
            [
                'name' => 'Keep events private to members',
                'parameter' => 'PRIVATE_EVENTS',
                'type' => 2,
                'sort_order' => 4
            ]
        ]);
    }
}
