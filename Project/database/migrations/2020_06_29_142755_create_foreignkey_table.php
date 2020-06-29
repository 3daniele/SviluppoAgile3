<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForeignkeyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Hosting
        Schema::table('hosting', function(Blueprint $table0) {
            $table0->foreign('user')->references('id')
                ->on('users')->onDelete('cascade'); });

        Schema::table('hosting', function(Blueprint $table0) {
            $table0->foreign('genre')->references('id_genre')
                ->on('genre')->onDelete('cascade'); });
        //Enter
        Schema::table('enter', function(Blueprint $table0) {
            $table0->foreign('user')->references('id')
                ->on('users')->onDelete('cascade'); });

        Schema::table('enter', function(Blueprint $table0) {
            $table0->foreign('hosting')->references('id_hosting')
                ->on('hosting')->onDelete('cascade'); });
        
        //BanUser
        Schema::table('banUser', function(Blueprint $table0) {
            $table0->foreign('user')->references('id')
                ->on('users')->onDelete('cascade'); });

        Schema::table('banUser', function(Blueprint $table0) {
            $table0->foreign('hosting')->references('id_hosting')
                ->on('hosting')->onDelete('cascade'); });

        //PlayList
        Schema::table('playlist', function(Blueprint $table0) {
            $table0->foreign('hosting')->references('id_hosting')
                ->on('hosting')->onDelete('cascade'); });

        Schema::table('playlist', function(Blueprint $table0) {
            $table0->foreign('music')->references('id_music')
                ->on('music')->onDelete('cascade'); });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
    }
}
