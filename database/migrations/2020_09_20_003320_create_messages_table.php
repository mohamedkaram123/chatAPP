<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('from_user');
            $table->unsignedInteger('to_user')->nullable();
            $table->text('content')->nullable();
            $table->string('record')->nullable();
            $table->string('files')->nullable();
            $table->tinyInteger('clear_chat_user1')->default(0);
            $table->tinyInteger('clear_chat_user2')->default(0);
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
        Schema::dropIfExists('messages');
    }
}
