<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'blog_name',
        'url',
        'title',
        'url',
        'privacy',
        'password'
    ];

    
    public function followers()
    {
        return $this->hasMany(Follow::class);
    }

    public function followedBy(User $user)
    {
        return $this->Followers->contains('user_id', $user->id);
    }

    public function settings()
    {
        return $this->hasOne(BlogSettings::class, 'blog_id', 'id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'blog_users', 'blog_id', 'user_id');
    }

    public function Posts()
    {
        return $this->hasMany(Posts::class,'blog_id');
    }

    public function UserFollowers()
    {
        return $this->belongsToMany(User::class ,'user_follow_blog', 'user_id', 'blog_id');
    }

    public function isfollower(User $user)
    {
        return !! DB::table('user_follow_blog')->where('user_id',$user->id)->where('blog_id',$this->id)->first();
    }
    // public function Follows()
    // {
    //     return $this->hasMany(Follow::class,'blog_id');
    // }

    public function BlockedBlogs()
    {
        return $this->belongsToMany(Blog::class,'blocks','blog_id','blocked_blog_id');
    }

    public function Blocks()
    {
        return $this->hasMany(Block::class,'blog_id');
    }


}
