<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Contracts\JWTSubject;
use JustBetter\PaginationWithHavings\PaginationWithHavings;
use DB;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use PaginationWithHavings;
    use SoftDeletes;

    const PENDING_STATUS = '0';
    const ACCEPT_STATUS = '1';
    const DECLINE_STATUS = '2';
    const BLOCKED_STATUS = '3';
    const USER_TYPE = 0;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }


    public function followings()
    {
        return $this->belongsToMany(User::class, 'relationship', 'user_one_id', 'user_two_id')
            ->where('status', self::ACCEPT_STATUS)
            ->withPivot('relation_ship_id')
            ->withTimestamps();
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'relationship', 'user_two_id', 'user_one_id')
            ->where('status', self::ACCEPT_STATUS)
            ->withPivot('relation_ship_id')
            ->withTimestamps();
    }

    public function pendingRequests()
    {
        return $this->belongsToMany(User::class, 'relationship', 'user_two_id', 'user_one_id')
            ->where('status', self::PENDING_STATUS)
            ->withPivot('relation_ship_id')
            ->withTimestamps();
    }

    public function requestedUsers()
    {
        return $this->belongsToMany(User::class, 'relationship', 'user_one_id', 'user_two_id')
            ->where('status', self::PENDING_STATUS)
            ->withPivot('relation_ship_id')
            ->withTimestamps();
    }

    public function blockUser()
    {
        return $this->hasOne(BlockUser::class, 'block_user_id', 'id')->where('user_id', auth()->user()->id);
    }

    public function blockUsers()
    {
        return $this->belongsToMany(User::class, 'block_user', 'user_id', 'block_user_id');
    }

    public function restrictedUsers()
    {
        return $this->belongsToMany(User::class, 'block_user', 'block_user_id', 'user_id');
    }
}
