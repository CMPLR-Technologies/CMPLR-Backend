<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogUsersTable extends Migration
{
    public function up()
    {
        Schema::create('blog_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('restrict');
            $table->foreignId('blog_id')->constrained()->onDelete('restrict');
            $table->boolean('primary')->default(false);
            $table->boolean('full_privileges')->nullable();
            $table->boolean('contributor_privileges')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('blog_users');
    }
}