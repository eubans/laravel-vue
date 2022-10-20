<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modules', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger('user_type_id');
            $table->index('user_type_id');
            $table->string('name');
            $table->string('url');
            $table->foreign('user_type_id')->references('user_type_id')->on('users');
            $table->integer('isAccessible');
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
        Schema::dropIfExists('modules');
    }
}
