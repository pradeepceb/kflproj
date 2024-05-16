<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTmShiftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tm_shifts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('Scode');
            $table->string('InTime');
            $table->string('outtime');
            $table->string('Wrkhrs');
            $table->string('HdStart');
            $table->string('HdEnd');
            $table->string('RstOut');
            $table->string('Rstin');
            $table->string('Rsthrs');
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
        Schema::dropIfExists('tm_shifts');
    }
}
