<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;


class Users extends Model implements  AuthenticatableContract
{
    use Authenticatable;
    protected $table = 'users';
    protected $primaryKey = 'user_id';

    protected $fillable = ['email', 'password'];

    protected $hidden = ['password'];
}
