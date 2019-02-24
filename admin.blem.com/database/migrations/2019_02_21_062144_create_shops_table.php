<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->increments('id');                   //主键
            $table->integer('shop_category_id');      //	店铺分类ID
            $table->string('shop_name');              //名称
            $table->string('shop_img');               //	店铺图片
            $table->float('shop_rating');             //评分
            $table->boolean('brand');                 //	是否是品牌
            $table->boolean('on_time');               //	是否准时送达
            $table->boolean('fengniao');              //是否蜂鸟配送
            $table->boolean('bao');                   //	是否保标记
            $table->boolean('piao');                  //	是否票标记
            $table->boolean('zhun');                  //是否准标记
            $table->float('start_send');              //起送金额
            $table->float('send_cost');               //	配送费
            $table->string('notice');                 //店公告
            $table->string('discount');               //优惠信息
            $table->integer('status');                //状态:1正常,0待审核,-1禁用
            $table->timestamps();
            $table->engine('InnoDB');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shops');
    }
}
