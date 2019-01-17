<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PrivateApi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('private_api', function($table){
            $table->string('app')->primary();
            $table->string('ticket')->comment('票据');
            $table->text('api_list')->nullable()->comment('api列表，以“,”隔开,all表示全部');
            $table->text('ip_allow')->nullable()->comment('ip白名单，以“,”隔开,all表示全部');
            $table->string('note')->nullable()->comment('备注');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('private_api');
    }
}
