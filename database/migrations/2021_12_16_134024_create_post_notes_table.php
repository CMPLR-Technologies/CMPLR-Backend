<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostNotesTable extends Migration
{
    public function up()
    {
        Schema::create('post_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->constrained()->onDelete('cascade');
            $table->foreignId('post_id')->references('id')->on('posts')->constrained()->onDelete('cascade');
            $table->text('type'); // like - reply - reblog - reblogwithcontent
            $table->text('content')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('post_notes');
    }
}
