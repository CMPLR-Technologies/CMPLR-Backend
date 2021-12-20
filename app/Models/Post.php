<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'blog_id',
        'content',
        'layout',
        'format',
        'mobile',
        'post_ask_submit',
        'source_user_id',
        'is_anonymous',
        'type',
        'source_title',
        'tags',
    ];

}
