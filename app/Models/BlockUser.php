<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlockUser extends Model
{
    protected $table = 'block_user';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];


}
