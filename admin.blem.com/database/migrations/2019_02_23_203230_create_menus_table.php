<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->increments('id');
            $table->string('goods_name');//菜名
            $table->float('rating');//评分
            $table->tinyInteger('shop_id');//所属商家ID
            $table->tinyInteger('category_id');//所属分类ID
            $table->decimal('goods_price','8','2');//价格
            $table->string('description');//描述
            $table->tinyInteger('month_sales');//月销量
            $table->tinyInteger('rating_count');//评分数量
            $table->string('tips');//提示信息
            $table->tinyInteger('satisfy_count');//满意度数量
            $table->float('satisfy_rate');//满意度评分
            $table->string('goods_img');//商品图片
            $table->tinyInteger('status');//状态：1上架，0下架
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
        Schema::dropIfExists('menus');
    }
}
