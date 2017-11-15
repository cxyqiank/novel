<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNovelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('novels', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name',100)->comment('小说名称');
            $table->string('pic',255)->comment('小说封面');
            $table->string('author',100)->comment('小说作者');
            $table->text('desc')->comment('小说描述');
            $table->tinyInteger('status')->comment('是否完结');
            $table->Integer('sections')->comment('章节数量');
            $table->timestamps();
            $table->index('name');
            $table->index('author');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('novels');
    }
}
