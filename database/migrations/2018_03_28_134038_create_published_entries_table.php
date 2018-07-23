<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePublishedEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('published_entries', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('publish_id');
            $table->integer('entry_id');
            $table->timestamps();

            $table->index('publish_id');
            $table->index('entry_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('published_entries');
    }
}
