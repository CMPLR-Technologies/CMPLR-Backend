<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserFollowBlog extends Migration
{
    public function up()
    {
        Schema::create('user_follow_blog', function (Blueprint $table) {
            $table->id();
            $table->foreignId('blog_id')->references('id')->on('blogs')->onDelete('restrict');
            $table->foreignId("user_id")->references('id')->on('users')->onDelete('restrict');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_follow_blog');
    }
}
