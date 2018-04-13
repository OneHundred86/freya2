<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LogAccess extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_access', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('type');
            $table->string('api');
            $table->text('params')->nullable();
            $table->string('ip');
            $table->timestamps();
            $table->index(['user_id', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('log_access');
    }
}
