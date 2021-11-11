<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string("blog_name");
            $table->string("type");
            $table->jsonb("content");
            $table->json("layout");
            $table->string("url");
            $table->date("date");
            $table->string("format");
            $table->string("source_url");
            $table->string("reblog_key")->nullable();
            $table->integer("blog_id");
            $table->boolean("mobile");
            $table->string("source_title")->nullable();
            $table->string("state");
            $table->integer("parent_post_id")->nullable();
            $table->string("parent_blog_id")->nullable();
            $table->string("post_ask_submit")->nullable();
            $table->integer("target_user_id")->nullable();
            $table->boolean("is_anonymous")->nullable();
            $table->boolean("is_approved")->nullable();
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
        Schema::dropIfExists('posts');
    }
}
