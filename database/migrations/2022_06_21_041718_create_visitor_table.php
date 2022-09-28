<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisitorTable extends Migration
{


    public function up()
    {
        Schema::create('visitor', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('click');
            $table->integer('viewer');
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::drop("visitor");
    }
}