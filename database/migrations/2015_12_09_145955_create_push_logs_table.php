<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePushLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('push_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('msgsno');
            $table->string('msgtype');
            $table->string('msgtitle');
            $table->string('msgcontent');
            $table->string('msgtime');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('push_logs');
    }
}
