<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media_info', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('media_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->text('description')->nullable();
            $table->text('author')->nullable();
            $table->text('place_of_creation')->nullable();
            $table->text('copyright')->nullable();
            $table->text('license')->nullable();
            $table->timestamps();

            $table->foreign("media_id")->references("id")->on("media");
            $table->foreign("user_id")->references("id")->on("users");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('media_info');
    }
}
