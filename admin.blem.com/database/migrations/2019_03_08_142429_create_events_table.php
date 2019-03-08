<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');//活动名称
            $table->text('content');//活动详情
            $table->integer('signup_start');//报名开始时间
            $table->integer('signup_end');//报名结束时间
            $table->date('prize_date');//开奖日期
            $table->integer('signup_num');//报名人数限制
            $table->tinyInteger('is_prize');//是否开奖
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
        Schema::dropIfExists('events');
    }
}
