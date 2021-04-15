<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SyUser extends Model
{
    public $table = 'sy_user';
    use SoftDeletes;
}
