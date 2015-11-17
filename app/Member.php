<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Member
 * @package App
 * @mixin \Eloquent
 */
class Member extends Model
{
    protected $connection = 'mysql_old';

    protected $table = 'member';

    public $timestamps = false;

}
