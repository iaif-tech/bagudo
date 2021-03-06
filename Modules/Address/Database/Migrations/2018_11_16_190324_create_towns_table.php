<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTownsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('towns', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('lga_id')
            ->default()
            ->unsigned()
            ->foreign()
            ->refernces('id')
            ->on('lgas')
            ->delete('restrict')
            ->update('cascade');
            $table->integer('district_id')
            ->default()
            ->unsigned()
            ->foreign()
            ->refernces('id')
            ->on('districts')
            ->delete('restrict')
            ->update('cascade');
            $table->string('name');
            $table->string('code')->nullable();
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
        Schema::dropIfExists('towns');
    }
}
