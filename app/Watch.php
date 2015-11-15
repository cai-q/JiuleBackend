<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Watch
 * @package App
 * @mixin \Eloquent
 */
class Watch extends Model
{
    protected $connection = 'mysql_old';

    protected $table = 'data';
}
