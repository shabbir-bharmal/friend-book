<?php

namespace App\Interfaces;
use App\Models\User;

interface UserRepositoryInterface
{
    public function create($user_data);

    public function updateById($user_id, $user_data);

    public function updateRelationship($from_user_id,$to_user_id,$status);

    public function byId($user_id);

    public function createRelationship($from_user_id,$to_user_id,$status);

    public function findUsersByActivityOrDistance(User $user, $params);

    public function delete($user_id);

    public function blockUser($user_id,$block_user_id);

    public function unblockUser($user_id,$unblock_user_id);
}