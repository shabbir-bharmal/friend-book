<?php

use Illuminate\Database\Seeder;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('setting')->insert([
            [
                'name' => 'Follow Requests',
                'parameter' => 'FOLLOW_REQUESTS',
                'type' => 1,
                'sort_order' => 1
            ],
            [
                'name' => 'Follow Acceptance',
                'parameter' => 'FOLLOW_ACCEPTANCE',
                'type' => 1,
                'sort_order' => 2

            ],
            [
                'name' => 'Upcoming Events',
                'parameter' => 'UPCOMING_EVENTS',
                'type' => 1,
                'sort_order' => 3

            ],
            [
                'name' => 'Event Invites',
                'parameter' => 'EVENT_INVITES',
                'type' => 1,
                'sort_order' => 4

            ],
            [
                'name' => 'Event Changes',
                'parameter' => 'EVENT_CHANGES',
                'type' => 1,
                'sort_order' => 5

            ],
            [
                'name' => 'Followers Activity',
                'parameter' => 'FOLLOWERS_ACTIVITY',
                'type' => 1,
                'sort_order' => 6

            ],
            [
                'name' => 'Post Activity',
                'parameter' => 'POST_ACTIVITY',
                'type' => 1,
                'sort_order' => 7

            ],
            [
                'name' => 'Company Promotions',
                'parameter' => 'COMPANY_PROMOTIONS',
                'type' => 1,
                'sort_order' => 8

            ],
            [
                'name' => 'Email Notifications',
                'parameter' => 'EMAIL_NOTIFICATIONS',
                'type' => 1,
                'sort_order' => 9

            ],
            [
                'name' => 'Notification Sound',
                'parameter' => 'NOTIFICATION_SOUND',
                'type' => 2,
                'sort_order' => 10
            ],
            [
                'name' => 'Include Preview',
                'parameter' => 'INCLUDE_PREVIEW',
                'type' => 2,
                'sort_order' => 11
            ],
            [
                'name' => 'Who can see my posts?',
                'parameter' => 'WHO_CAN_SEE_POSTS',
                'type' => 3,
                'sort_order' => 12
            ],
            [
                'name' => 'Who can see my followers?',
                'parameter' => 'WHO_CAN_SEE_FOLLOWERS',
                'type' => 3,
                'sort_order' => 13

            ],
            [
                'name' => 'Who can see my calendar?',
                'parameter' => 'WHO_CAN_SEE_CALENDAR',
                'type' => 3,
                'sort_order' => 14

            ],
            [
                'name' => 'Who can see my information?',
                'parameter' => 'WHO_CAN_SEE_INFORMATION',
                'type' => 3,
                'sort_order' => 15

            ],
            [
                'name' => 'Who can message me?',
                'parameter' => 'WHO_CAN_MESSAGE_ME',
                'type' => 3,
                'sort_order' => 16

            ],
            [
                'name' => 'Who can see my media?',
                'parameter' => 'WHO_CAN_SEE_MEDIA',
                'type' => 3,
                'sort_order' => 17

            ],
            [
                'name' => 'Who can see my wish list?',
                'parameter' => 'WHO_CAN_SEE_WISHLIST',
                'type' => 3,
                'sort_order' => 18

            ],
            [
                'name' => 'Who can see my map?',
                'parameter' => 'WHO_CAN_SEE_MAP',
                'type' => 4,
                'sort_order' => 19

            ],
            [
                'name' => 'Who can see my location?',
                'parameter' => 'WHO_CAN_SEE_LOCATION',
                'type' => 4,
                'sort_order' => 20
            ],
            [
                'name' => 'Nearby Me active?',
                'parameter' => 'NEARBY_ME_ACTIVE',
                'type' => 4,
                'sort_order' => 21
            ]

        ]);
    }
}
