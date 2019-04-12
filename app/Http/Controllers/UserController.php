<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Log;


/**
 * Class UserController
 */
class UserController extends Controller
{
    /**
     * @var $user_repository
     */
    protected $user_repository;
    /**
     * @var $user
     */
    protected $user;

    /**
     * @param $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->user_repository = $userRepository;
        $this->middleware(function ($request, $next) {
            $this->user= Auth::user();

            return $next($request);
        });
        //$this->user = Auth::user();
    }

    /**
     * Create new user
     * @param $request
     */
    public function store(UserRequest $request)
    {
        $user_data = $request->all();

        try {
            $user = $this->user_repository->create($user_data);
            Auth::login($user);

            return response()->json(['success' => true, 'user' => $user, 'token' => JWTAuth::fromUser($user)], JsonResponse::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Get current login user profile
     */
    public function me()
    {
        $user = $this->user;
        $user->load(['blockUsers', 'restrictedUsers', 'followers', 'followings', 'pendingRequests', 'requestedUsers']);
        return response()->json(['success' => true, 'user' => $user]);
    }

    /**
     * Update user profile
     * @param $request
     */
    public function update(UserRequest $request)
    {
        $user = $this->user;
        $user_data = $request->all();
        try {
            $user = $this->user_repository->updateById($user->id, $user_data);
            return response()->json(['success' => true, 'message' => "Profile updated successfully", 'user' => $user], JsonResponse::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * Follow user
     * @param $request
     */
    public function follow(Request $request)
    {
        $user = $this->user;
        $to_users = $request->get('user_id');
        if (empty($to_users)) {
            return response()->json(['success' => false, 'message' => "Please provide user id(s) to follow"], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
        if (is_string($to_users)) {
            $to_users = [$to_users];
        }

        foreach ($to_users as $to_user) {
            $follow_user = $this->user_repository->byId($to_user);
            if (empty($follow_user) || $to_user == $user->id) {
                continue;
            }
            try {
                $this->user_repository->createRelationship($user->id, $to_user, User::PENDING_STATUS);
            } catch (\Exception $e) {
                continue;
            }
        }

        return response()->json(['success' => true, 'message' => "Following request sent successfully"], JsonResponse::HTTP_OK);
    }

    /**
     * Unfollow user
     * @param $request
     */
    public function unfollow(Request $request)
    {
        $user = $this->user;
        $to_user_id = $request->get('user_id');
        if (empty($to_user_id)) {
            return response()->json(['success' => false, 'message' => "Please provide user id(s) to unfollow"], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        try {
            $unfollow = $this->user_repository->updateRelationship($user->id, $to_user_id, User::BLOCKED_STATUS);
            if ($unfollow) {
                return response()->json(['success' => true, 'message' => "Unfollow successfully"], JsonResponse::HTTP_OK);
            } else {
                return response()->json(['success' => false, 'message' => "Something went wrong"], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
            }

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Approve follow request
     * @param $request
     */
    public function approve(Request $request)
    {
        $user = $this->user;
        $from_user_id = $request->get('user_id');
        $from_user = $this->user_repository->byId($from_user_id);
        if (empty($from_user)) {
            return response()->json(['success' => false, 'message' => "User not found"], JsonResponse::HTTP_NOT_FOUND);
        }
        try {
            $acceptRequest = $this->user_repository->updateRelationship($from_user_id, $user->id, User::ACCEPT_STATUS);

            if ($acceptRequest) {
                return response()->json(['success' => true, 'message' => "Request accepted successfully"], JsonResponse::HTTP_OK);
            } else {
                return response()->json(['success' => false, 'message' => "Something went wrong"], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
            }

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Reject follow request
     * @param $request
     */
    public function reject(Request $request)
    {
        $user = $this->user;
        $from_user_id = $request->get('user_id');
        $from_user = $this->user_repository->byId($from_user_id);
        if (empty($from_user)) {
            return response()->json(['success' => false, 'message' => "User not found"], JsonResponse::HTTP_NOT_FOUND);
        }

        try {
            $rejectRequest = $this->user_repository->updateRelationship($from_user_id, $user->id, User::DECLINE_STATUS);
            if ($rejectRequest) {
                return response()->json(['success' => true, 'message' => "Request rejected successfully"], JsonResponse::HTTP_OK);
            } else {
                return response()->json(['success' => false, 'message' => "Something went wrong"], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * Get other user's details
     * @param $user_id
     */
    public function get($user_id)
    {
        $logged_user = $this->user;
        try {
            $user = $this->user_repository->byId($user_id);

            if($user) {
                if ($user->followings->contains('id', $logged_user->id) || $user->followers->contains('id', $logged_user->id)) {
                    $user->setAttribute('follow', true);
                } else {
                    $user->setAttribute('follow', false);
                }
                return response()->json(['success' => true, 'user' => $user], JsonResponse::HTTP_OK);
            } else {
                return response()->json(['success' => false, 'message' => "User not found"], JsonResponse::HTTP_NOT_FOUND);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * Get pending follow request
     */
    public function followRequest()
    {
        $user = $this->user;
        $user->load(['pendingRequests']);
        return response()->json(['success' => true, 'users' => $user->pendingRequests]);
    }

    /**
     * Search for all the users
     * @param $request
     */
    public function searchUsers(Request $request)
    {
        $params = $request->all();
        try {
            $users = $this->user_repository->findUsersByActivityOrDistance(Auth::user(), $params);
            return response()->json(['success' => true, 'users' => $users], JsonResponse::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Get list of friends
     */
    public function getFriends()
    {
        $user = $this->user;
        $user->load('followers', 'followings');
        $followers = $user->followers;
        $followings = $user->followings;
        $friends = collect();
        if (!empty($followers)) {
            $friends = $friends->merge($followers);
        }
        if (!empty($followings)) {
            $friends = $friends->merge($followings);
        }

        if (!empty($user) && !empty($user->blockUsers)) {
            $friends = $friends->filter(function ($u) use ($user) {
                return !($user->blockUsers->contains('id', $u->id));
            });
        }
        $friends = $friends->unique('id')->values()->all();
        return response()->json(['success' => true, 'users' => $friends], JsonResponse::HTTP_OK);
    }

    /**
     * Delete user
     */
    public function delete()
    {
        try {
            $user_id = Auth::user()->id;
            $this->user_repository->delete($user_id);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json(['success' => true, 'message' => "Account deleted successfully"], JsonResponse::HTTP_OK);
    }

    /**
     * Block user
     * @param $block_user_id
     */
    public function blockUser($block_user_id)
    {
        $user_id = $this->user;
        $block_user = $this->user_repository->byId($block_user_id);
        if (empty($block_user)) {
            return response()->json(['success' => false, 'message' => "User not found"], JsonResponse::HTTP_NOT_FOUND);
        }

        if ($block_user_id == $user_id->id) {
            return response()->json(['success' => false, 'message' => "I know you hate your self but you can't perform this operation here"], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        try {
            $blockUser = $this->user_repository->blockUser($user_id->id, $block_user_id);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json(['success' => true, 'message' => $block_user->name . " has been blocked successfully"], JsonResponse::HTTP_OK);
    }

    /**
     * unblock user
     * @param $unblock_user_id
     */
    public function unblockUser($unblock_user_id)
    {
        $user_id = $this->user;
        $unblock_user = $this->user_repository->byId($unblock_user_id);
        if (empty($unblock_user)) {
            return response()->json(['success' => false, 'message' => "User not found"], JsonResponse::HTTP_NOT_FOUND);
        }
        if ($unblock_user_id == $user_id->id) {
            return response()->json(['success' => false, 'message' => "That is Insane"], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        try {
            $unblockUser = $this->user_repository->unblockUser($user_id->id, $unblock_user_id);
            if ($unblockUser) {
                return response()->json(['success' => true, 'message' => $unblock_user->name . " has been unblocked successfully"], JsonResponse::HTTP_OK);
            } else {
                return response()->json(['success' => false, 'message' => "You can not unblock user which is not in your block list"], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Get list of followers
     */
    public function getFollowings()
    {

        $user = $this->user;
        $user->load('followings');
        $followings = $user->followings;

        $friends = collect();

        if (!empty($followings)) {
            $friends = $followings;
        }

        if (!empty($user) && !empty($user->blockUsers)) {
            $friends = $friends->filter(function ($u) use ($user) {
                return !($user->blockUsers->contains('id', $u->id));
            });
        }
        $friends = $friends->unique('id')->values()->all();
        return response()->json(['success' => true, 'users' => $friends], JsonResponse::HTTP_OK);
    }

}
