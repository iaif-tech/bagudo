<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDoctorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('role_id')
            ->nullable()
            ->unsigned()
            ->foreign()
            ->refernces('id')
            ->on('roles')
            ->delete('restrict')
            ->update('cascade');
            $table->integer('hospital_id')
            ->nullable()
            ->unsigned()
            ->foreign()
            ->references('id')
            ->on('hospitals')
            ->delete('restrict')
            ->update('cascade');
            $table->integer('profile_id')
            ->nullable()
            ->unsigned()
            ->foreign()
            ->references('id')
            ->on('profiles')
            ->delete('restrict')
            ->update('cascade');
            $table->integer('gender_id')
            ->nullable()
            ->unsigned()
            ->foreign()
            ->references('id')
            ->on('genders')
            ->delete('restrict')
            ->update('cascade');
            $table->integer('discpline_id')
            ->nullable()
            ->unsigned()
            ->foreign()
            ->references('id')
            ->on('discplines')
            ->delete('restrict')
            ->update('cascade');
            $table->integer('state_id')
            ->nullable()
            ->unsigned()
            ->foreign()
            ->references('id')
            ->on('states')
            ->delete('restrict')
            ->update('cascade');
            $table->integer('hospital_department_id')
            ->nullable()
            ->unsigned()
            ->foreign()
            ->references('id')
            ->on('hospital_department')
            ->delete('restrict')
            ->update('cascade');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone')->nullable();
            $table->string('email')->nullable()->unique();
            $table->string('image')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('doctors');
    }
}
