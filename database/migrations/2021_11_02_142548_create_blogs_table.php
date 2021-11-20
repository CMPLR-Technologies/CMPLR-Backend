<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogsTable extends Migration
{
    public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('blog_name')->unique();
            $table->string('url')->unique();
            $table->string('title')->default('untitled');
            $table->boolean('public')->default(true);
            $table->boolean('privacy')->default(false);
            $table->bigInteger('followers')->default(0);
            $table->string('password')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('blogs');
    }
}
