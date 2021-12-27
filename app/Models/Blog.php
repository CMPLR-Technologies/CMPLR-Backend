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

    protected $hidden = [
        'password',
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

    public function messages()
    {
        return $this->hasMany(Chat::class ,'to_blog_id' );
    }
    public function Posts()
    {
        return $this->hasMany(Posts::class,'blog_id');
    }

    public function UserFollowers()
    {
        return $this->belongsToMany(User::class ,'follows', 'user_id', 'blog_id');
    }

    public function isfollower()
    {
        if (auth('api')->check()) 
            return !! DB::table('follows')->where('user_id',auth('api')->user()->id)->where('blog_id',$this->id)->first();
        return false;
    }
  
    public function user_blogs()
    {
        return $this->hasMany(BlogUser::class);
    }

    public function count_posts()
    {
        return Posts::where('blog_id',$this->id)->count();
    }

    public function count_followers()
    {
        return Follow::where('blog_id',$this->id)->count();
    }

    public function BlockedBlogs()
    {
        return $this->belongsToMany(Blog::class,'blocks','blog_id','blocked_blog_id');
    }

    public function Blocks()
    {
        return $this->hasMany(Block::class,'blog_id');
    }

    public function IsMine()
    {
        if (auth('api')->check()) 
            return !! BlogUser::where('user_id',auth('api')->user()->id)->where('blog_id',$this->id)->first();
        return false;
       
    }


}
