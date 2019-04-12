<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\Relationship;
use App\Models\User;
use App\Models\BlockUser;
use DB;
use Illuminate\Support\Facades\Auth;

/**
 *
 */
class UserRepository implements UserRepositoryInterface
{

    /**
     *
     */
    public function __construct()
    {

    }

    /**
     * Create new user
     * @param $user_data
     */
    public function create($user_data)
    {
        $user = new User();
        $user->name = $user_data['name'];
        $user->email = !empty($user_data['email']) ? $user_data['email'] : null;
        $user->password = !empty($user_data['password']) ? bcrypt($user_data['password']) : null;
        $user->save();

        return $user;
    }

    /**
     * Update user data
     * @param $user_id
     * @param $user_data
     */
    public function updateById($user_id, $user_data)
    {
        $user = User::find($user_id);
        $user->name = !empty($user_data['name']) ? $user_data['name'] : $user->name;
        $user->password = !empty($user_data['password']) ? bcrypt($user_data['password']) : $user->password;
        $user->save();
        return $user;
    }

    /**
     * Update friend request status to accepted/declined/rejected
     * @param $from_user_id
     * @param $to_user_id
     * @param $status
     */
    public function updateRelationship($from_user_id, $to_user_id, $status)
    {
        $relationship = Relationship::where(['user_one_id' => $from_user_id, 'user_two_id' => $to_user_id])->first();
        if ($relationship) {
            if ($status == User::BLOCKED_STATUS) {
                return $relationship->delete();
            } else {
                $relationship->status = $status;
                $relationship->action_user_id = $from_user_id;
                $relationship->save();
                return $relationship;
            }
        } else {
            return false;
        }
    }

    /**
     * Send friend request to user
     * @param $from_user_id
     * @param $to_user_id
     * @param $status
     */
    public function createRelationShip($from_user_id, $to_user_id, $status)
    {
        $relationship = Relationship::where('user_one_id', $from_user_id)->where('user_two_id', $to_user_id)->first();
        if ($relationship == null) {
            $relationship = new Relationship();
            $relationship->user_one_id = $from_user_id;
            $relationship->user_two_id = $to_user_id;
        }
        $relationship->status = $status;
        $relationship->action_user_id = $from_user_id;
        $relationship->save();
        return $relationship;
    }

    /**
     * Get single user details
     * @param $user_id
     */
    public function byId($user_id)
    {
        return User::with(['followers', 'followings'])
            ->where('id', $user_id)
            ->first();
    }

    /**
     * Search all users
     * @param $user
     * @param $params
     */
    public function findUsersByActivityOrDistance(User $user, $params)
    {
        $user_id = $user->id;
        $followings = $user->followings->pluck('id')->toArray();

        $users = User::with(['followers', 'followings'])
            ->doesntHave('blockUser')
            ->where('id', '!=', $user_id);

        if(!empty($params['following']) && $params['following']=='true') {
            if(!empty($followings)){
                $users->whereIn('id',$followings);
            } else {
                return [];
            }
        }

        return $users->get();
    }


    /**
     *  Delete user record
     * @param $user_id
     */
    public function delete($user_id)
    {
        return User::find($user_id)->delete();
    }

    /**
     * Block the user
     * @param $user_id
     * @param  $block_user_id
     */
    public function blockUser($user_id, $block_user_id)
    {
        return BlockUser::create(['user_id' => $user_id, 'block_user_id' => $block_user_id]);
    }

    /**
     * Unblock the user
     * @param $user_id
     * @param $unblock_user_id
     */
    public function unblockUser($user_id, $unblock_user_id)
    {
        return BlockUser::where('user_id', $user_id)->where('block_user_id', $unblock_user_id)->delete();
    }

}