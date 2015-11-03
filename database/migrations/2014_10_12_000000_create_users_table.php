<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('serial')->comments('企业编号');
            $table->string('name')->comments('企业名称');
            $table->string('email')->unique('登陆邮箱');
            $table->integer('user_type')->comments('0 系统管理员；1 父级企业用户；2 子级企业用户');
            $table->unsignedInteger('parent_id');
            $table->string('password', 60);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
