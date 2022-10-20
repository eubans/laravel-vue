<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->text('message')->nullable();
            $table->text('link')->nullable();
            $table->string('text_color')->comment('success/primary/secondary/danger/info/warning')->default('info');  
            $table->string('send_to')->comment('all/individual')->default('individual'); 
            $table->foreignId('send_to_user_id')->nullable()->references('id')->on('users');
            $table->timestamp('send_when')->nullable();
            $table->foreignId('created_by')->nullable()->references('id')->on('users');
            $table->foreignId('updated_by')->nullable()->references('id')->on('users'); 
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
        Schema::dropIfExists('notifications');
    }
}
