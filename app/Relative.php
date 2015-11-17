<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Relative extends Model
{
    protected $connection = 'mysql_old';

    protected $table = 'member_relatives';
}
