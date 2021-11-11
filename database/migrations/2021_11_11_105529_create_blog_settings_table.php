<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('repiles')->nullable();
            $table->boolean('allow_ask')->nullable();
            $table->boolean('ask_page_title')->nullable();
            $table->boolean('allow_anonymous_question')->nullable();
            $table->boolean('allow_submissions')->nullable();
            $table->text('submission_page_title')->nullable();
            $table->text('submission_guidelines')->nullable();
            $table->boolean('is_text_allowed')->nullable();
            $table->boolean('is_photo_allowed')->nullable();
            $table->boolean('is_link_allowed')->nullable();
            $table->boolean('is_quote_allowed')->nullable();
            $table->boolean('is_video_allowed')->nullable();
            $table->boolean('allow_messaging')->nullable();
            $table->integer('posts_per_day')->nullable();
            $table->integer('posts_start')->nullable();
            $table->integer('posts_end')->nullable();
            $table->boolean('dashboard_hide')->nullable();
            $table->boolean('search_hide')->nullable();
            $table->text('header_image')->nullable();
            $table->text('avatar')->nullable();
            $table->text('avatar_shape')->nullable();
            $table->text('background_color')->nullable();
            $table->text('accent_color')->nullable();
            $table->boolean('show_header_image')->nullable();
            $table->boolean('show_avatar')->nullable();
            $table->boolean('show_title')->nullable();
            $table->boolean('show_description')->nullable();
            $table->boolean('use_new_post_type')->nullable();
            $table->boolean('show_navigation');
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
        Schema::dropIfExists('blog_settings');
    }
}
