<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->increments('id');               //主键
            $table->integer('user_id');             //用户id
            $table->string('province');             //省
            $table->string('city');                 //	市
            $table->string('area');                 //区
            $table->string('detail_address');      //详细地址
            $table->string('tel');                  //收货人电话
            $table->string('name');                 //收货人姓名
            $table->integer('is_default');         //是否是默认地址
            $table->engine='InnoDB';        //数据库引擎
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
        Schema::dropIfExists('addresses');
    }
}
