<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModuleAccessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('module_accesses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_type_id');
            $table->index('user_type_id');
            $table->foreign('user_type_id')->references('id')->on('user_types');
            $table->unsignedBigInteger('sub_module_id');
            $table->index('sub_module_id');
            $table->foreign('sub_module_id')->references('id')->on('sub_modules');
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
        Schema::dropIfExists('module_accesses');
    }
}
