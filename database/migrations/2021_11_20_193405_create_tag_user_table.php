<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagUserTable extends Migration
{
    public function up()
    {
        Schema::create('tag_users', function (Blueprint $table) {
            $table->string('tag_name');
            $table->foreign('tag_name')->references('name')->on('tags')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->references('id')->on('users')->constrained()->onDelete('cascade');
            $table->primary(['tag_name', 'user_id']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tag_users');
    }
}
