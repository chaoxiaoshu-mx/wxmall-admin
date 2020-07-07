<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->integer('parent_id');   // 父级分类id
            $table->integer('level');       // 分类等级[0,1,2] 0：顶级
            $table->string('icon');
            $table->boolean('checked')->default(false);   // 是否选中
            $table->boolean('spread')->default(false);    // 是否展开
            $table->timestamps();
            $table->softDeletes();  // 软删除
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
