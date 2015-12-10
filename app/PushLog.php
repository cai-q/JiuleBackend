<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PushLog
 * @package App
 * @mixin \Eloquent
 */
class PushLog extends Model
{
    protected $table = 'push_logs';

    public $timestamps = false;

}
