<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'source_content'
    ];

    protected $casts = [
        'tags' => 'json'
    ];
    

    // post belong to one blog
    public function BLogs()
    {
        return $this->belongsTo(Blog::class,'blog_id');
    }

    function notes ()
    {
        return $this->hasMany(PostNotes::class);
    }
}