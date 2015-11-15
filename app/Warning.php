<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Warning
 * @package App
 * @mixin \Eloquent
 */
class Warning extends Model
{
    protected $connection = 'mysql_old';

    protected $table = 'data_warn';
}
