<?php

namespace App\Models;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Posts extends Model
{
    use HasFactory;
    protected $fillable = [
        'blog_id',
        'type',
        'content',
        'state',
        'blog_name',
        'date',
        'tags',
        'source_content',
        'title'
    ];

    protected $casts = [
        'tags' => 'json'
    ];

    public function Tags()
    {
        return $this->hasMany(PostTags::class, 'post_id');
    }

    // post belong to one blog
    public function BLogs()
    {
        return $this->belongsTo(Blog::class, 'blog_id');
    }

    function notes()
    {
        return $this->hasMany(PostNotes::class);
    }

    function is_liked()
    {
        if (auth('api')->check())
            return !!PostNotes::where('user_id', auth('api')->user()->id)->where('post_id', '=', $this->id)->first();
        return false;
    }

    function count_notes()
    {
        return PostNotes::where('post_id', $this->id)->count();
    }
}