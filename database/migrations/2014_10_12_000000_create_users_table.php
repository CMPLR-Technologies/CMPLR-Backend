<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->integer('age');
            $table->integer('following_count')->nullable();
            $table->integer('likes_count')->nullable();
            $table->string('default_post_format')->nullable();
            $table->boolean('login_options')->default(false);
            $table->boolean('email_activity_check')->default(true);
            $table->boolean('TFA')->default(false);
            $table->json('filtered_tags')->nullable();
            $table->json('filtering_content')->nullable();
            $table->boolean('endless_scrolling')->nullable();
            $table->boolean('show_badge')->nullable();
            $table->string('text_editor')->nullable();
            $table->boolean('msg_sound')->nullable();
            $table->boolean('best_stuff_first')->nullable();
            $table->boolean('include_followed_tags')->nullable();
            $table->boolean('tumblr_news')->nullable();
            $table->boolean('conversational_notification')->nullable();
            $table->string('google_id')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
