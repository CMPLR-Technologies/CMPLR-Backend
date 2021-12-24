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
            $table->integer('from_blog_id')->nullable();        // nullable in case of anonymous
            $table->integer('to_blog_id');
            $table->string('type');                             // 'reblog' 'reply' 'like' 'follow' 'ask' 'answer'
            $table->integer('post_ask_answer_id')->nullable();  // nullable in case of 'follow'
            $table->string("date");
            $table->boolean('seen')->default(false);
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
