<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');//菜类名称
            $table->string('type_accumulation');//菜品编号（a-z前端使用）
            $table->integer('shop_id');//所属商家ID
            $table->string('description');//描述
            $table->tinyInteger('is_selected');//1为默认分类，0为非默认
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
        Schema::dropIfExists('menu_categories');
    }
}
