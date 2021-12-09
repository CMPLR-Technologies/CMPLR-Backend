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
            $table->integer('age');
            $table->integer('following_count')->default(0);
            $table->integer('likes_count')->default(0);
            $table->string('default_post_format')->nullable();
            $table->string('login_options')->nullable();
            $table->boolean('email_activity_check')->default(false);
            $table->boolean('TFA')->default(false);
            $table->json('filtered_tags')->nullable();
            $table->boolean('endless_scrolling')->default(true);
            $table->boolean('show_badge')->default(true);
            $table->string('text_editor')->default('rich');
            $table->boolean('msg_sound')->default(true);
            $table->boolean('best_stuff_first')->default(true);
            $table->boolean('include_followed_tags')->default(true);
            $table->boolean('conversational_notification')->default(true);
            $table->json('filtered_content')->nullable();
            $table->string('google_id')->nullable();
            $table->integer('primary_blog_id')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
