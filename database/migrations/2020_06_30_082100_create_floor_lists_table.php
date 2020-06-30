<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFloorListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('floor_lists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('image_src');
            $table->integer('floor_id');
            $table->string('open_type');
            $table->string('navigator_url');
            $table->string('description');
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
        Schema::dropIfExists('floor_lists');
    }
}
