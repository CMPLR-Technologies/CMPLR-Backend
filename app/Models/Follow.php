<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'blog_id'
    ];

    // public function FBlogs()
    // {
    //     return $this->belongsTo(Blog::class,'blog_id');
    // }
    

}
