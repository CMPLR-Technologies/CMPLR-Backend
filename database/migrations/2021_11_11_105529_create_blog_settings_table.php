<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogSettingsTable extends Migration
{
    public function up()
    {
        Schema::create('blog_settings', function (Blueprint $table) {
            $table->id();
            $table->integer("blog_id");
            $table->foreign('blog_id')->references('id')->on('blogs')->onDelete('cascade');
            $table->text('replies')->default('everyone');
            $table->boolean('allow_ask')->default(false);
            $table->text('ask_page_title')->default('Ask me anything');
            $table->boolean('allow_anonymous_question')->default(false);
            $table->boolean('allow_submissions')->default(false);
            $table->text('submission_page_title')->default('Submit a post');
            $table->longText('submission_guidelines')->nullable();
            $table->boolean('is_text_allowed')->default(true);
            $table->boolean('is_photo_allowed')->default(true);
            $table->boolean('is_link_allowed')->default(true);
            $table->boolean('is_quote_allowed')->default(true);
            $table->boolean('is_video_allowed')->default(true);
            $table->boolean('allow_messaging')->default(false);
            $table->integer('posts_per_day')->default(2);
            $table->integer('posts_start')->default(0);
            $table->integer('posts_end')->default(0);
            $table->boolean('dashboard_hide')->default(true);
            $table->boolean('search_hide')->default(true);
            $table->text('header_image')->default("https://assets.tumblr.com/images/default_header/optica_pattern_02_640.png?_v=b976ee00195b1b7806c94ae285ca46a7");
            $table->text('avatar')->default("https://assets.tumblr.com/images/default_avatar/cone_closed_128.png");
            $table->text('avatar_shape')->default('circle');
            $table->text('background_color')->default('white');
            $table->text('accent_color')->default('blue');
            $table->text('description')->default('');
            $table->boolean('show_header_image')->default(true);
            $table->boolean('show_avatar')->default(true);
            $table->boolean('show_title')->default(true);
            $table->boolean('show_description')->default(true);
            $table->boolean('use_new_post_type')->default(true);
            $table->boolean('show_navigation')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('blog_settings');
    }
}