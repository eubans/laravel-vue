<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->after('id', function ($table) {
                $table->string('user_role_id')->nullable()->comment('separated with comma');
                $table->foreignId('user_type_id')->nullable()->references('id')->on('user_types');
            });

            $table->after('password', function ($table) {
                $table->string('status', 15)->comment('active/inactive')->default('active');
            });

            $table->after('remember_token', function ($table) {
                $table->foreignId('created_by')->nullable()->references('id')->on('users');
                $table->foreignId('updated_by')->nullable()->references('id')->on('users');
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
