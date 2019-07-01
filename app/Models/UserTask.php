<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserTask extends Model
{
    protected $table = 'user_tasks';
    protected $primaryKey = 'user_task_id';
}
