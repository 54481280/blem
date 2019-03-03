<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');//用户ID
            $table->integer('shop_id');//shop_id
            $table->string('sn');//订单编号
            $table->string('province');//省
            $table->string('city');//市
            $table->string('county');//县
            $table->string('address');//详细地址
            $table->string('tel');//收货人电话
            $table->string('name');//收货人姓名
            $table->decimal('total',8,2);//价格
            $table->tinyInteger('status');//状态(-1:已取消,0:待支付,1:待发货,2:待确认,3:完成)
            $table->string('out_trade_no');//第三方交易号（微信支付需要）
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
        Schema::dropIfExists('orders');
    }
}
