<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHostingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hosting', function (Blueprint $table) {
            $table->id('id_hosting');
            $table->unsignedBigInteger('user');
            $table->string('name');
            $table->unsignedBigInteger('genre');
            $table->string('mod');
            $table->enum('type',['battle','democracy']);
            $table->enum('open',['yes','no']);
            $table->timestamp('create_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('party');
    }
}
