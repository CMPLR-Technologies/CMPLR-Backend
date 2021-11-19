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
            $table->string('title')->nullable();
            $table->boolean('primary')->default(False);
            $table->string('type')->nullable();
            $table->string('password')->nullable();
            $table->boolean('full_priveleges')->nullable();
            $table->boolean('contributor_priveleges')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('blogs');
    }
}
