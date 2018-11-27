<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CharacterAuth extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 角色权限表
        Schema::create('character_auth', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('character_id')->comment('角色id');
            $table->string('name')->comment('权限名');
            $table->index('character_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('character_auth');
    }
}
