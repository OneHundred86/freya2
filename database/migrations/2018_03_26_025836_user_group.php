<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Model\UserGroup as UserGroupModel;

class UserGroup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_group', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('characters')->comment("json,eg:[1,2]");
            $table->timestamps();
            $table->softDeletes();
        });

        $ug = new UserGroupModel;
        $ug->id = 1;
        $ug->name = '超级管理员';
        $ug->characters = json_encode([]);
        $ug->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_group');
    }
}
