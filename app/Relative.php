<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Relative
 * @package App
 * @mixin \Eloquent
 */
class Relative extends Model
{
    protected $connection = 'mysql_old';

    protected $table = 'member_relatives';

    public $timestamps = false;

}
