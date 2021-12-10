<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string("blog_name");                    // post owner | target in case of ask/submit
            $table->string("type");                         // post type
            $table->jsonb("content");                       // post content
            $table->json("layout")->nullable();
            $table->string("url")->nullable();
            $table->date("date")->nullable();
            $table->string("format")->nullable();
            $table->string("source_url")->nullable();
            $table->string("reblog_key")->nullable();
            $table->integer("blog_id")->nullable();
            $table->boolean("mobile");                      // was the post created through a mobile
            $table->string("source_title")->nullable();
            $table->string("state");                        // published,draft,queue,private
            $table->integer("parent_post_id")->nullable();
            $table->string("parent_blog_id")->nullable();
            $table->string("post_ask_submit")->nullable();  // is it ask or submit
            $table->integer("source_user_id")->nullable();  // post sender
            $table->boolean("is_anonymous")->nullable();    // is the sender an anonymous
            $table->boolean("is_approved")->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
