<?php
return [

    'notifications' =>[
        'FOLLOW_REQUESTS' => array(
            'title' => 'Title',
            'body' => 'New follow request from #User#.'
        ),
        'FOLLOW_ACCEPTANCE' => array(
            'title' => 'Title',
            'body' => '#User# has accepted your follow request.'
        ),
        'UPCOMING_EVENTS' => array(
            'title' => 'Title',
            'body' => 'You have upcoming events.'
        ),
        'EVENT_INVITES' => array(
            'title' => 'Title',
            'body' => 'You have been tagged in the #Event# at #Location# on #DateTime#.'
        ),
        'EVENT_CHANGES' => array(
            'title' => 'Title',
            'body' => 'The event #Event#, on which you are tagged has been updated.'
        ),
        'FOLLOWERS_ACTIVITY' => array(
            'title' => 'Title',
            'body' => array(
               'start_following' => '#FollowerUser# has started following #AnotherUser#.',
               'rate' => '#FollowerUser# has liked #No# post',
               'wentTo' => '#FollowerUser# went to #Event#.',
               'tag' => '#FollowerUser# has tagged you in a #Post#.',
               'like_post' => '#FollowerUser# has started the post by #PostUser#. #PostImage#'
            )
        ),
        'POST_ACTIVITY' => array(
            'title' => 'Title',
            'body' => array(
                'comment' => '#User# commented on your post.',
                'reply_comment' => '#User# has replied on your comment.',
                'tag' => '#User# has tagged you in a #Post# comment.',
                'post_tag' => '#FollowerUser# has tagged you in a #Post#.',
                'rate' => '#User# liked your post.',
            )
        ),
        'COMPANY_PROMOTIONS' => array(
            'title' => 'Title',
            'body' => 'Company Promotions'
        ),
        'GROUP_INVITATION_SENT' => array(
            'title' => 'Group Invitation Sent',
            'body' => 'There is new group invitation request from #User#.'
        ),
        'USER_JOINED_GROUP' => array(
            'title' => 'User Has Joined The Group',
            'body' => '#User# has joined the group #Group#.'
        ),
        'USER_JOIN_GROUP_REQUEST' => array(
            'title' => 'Group Join Request Sent',
            'body' => 'There is new group join request from #User#.'
        ),
        'GROUP_INVITATION_ACCEPTED_BY_USER' => array(
            'title' => 'Group Invitation Accepted',
            'body' => 'Group invitation accepted by #User#.'
        ),
        'GROUP_INVITATION_REJECTED_BY_USER' => array(
            'title' => 'Group Invitation Rejected',
            'body' => 'Group invitation rejected by #User#.'
        ),
        'GROUP_JOIN_REQUEST_ACCEPTED_BY_ADMIN' => array(
            'title' => 'Group Join Request Accepted',
            'body' => 'Group join request has been accepted by #User#.'
        ),
        'GROUP_JOIN_REQUEST_REJECTED_BY_ADMIN' => array(
            'title' => 'Group Join Request Rejected',
            'body' => 'Group join request has been rejected by #User#.'
        ),

    ]
];