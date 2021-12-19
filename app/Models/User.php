<?php

namespace App\Models;

use App\Models\BlogUser;
use App\Models\Follow;
use App\Models\Tag;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'email',
        'password',
        'google_id',
        'age',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function followings()
    {
        return $this->HasMany(Follow::class);
    }

    public function blogs()
    {
        return $this->hasMany(BlogUser::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'tag_users', 'user_id', 'tag_id');
    }

    public function FollowedBlogs()
    {
        return $this->belongsToMany(Blog::class ,'user_follow_blog', 'user_id', 'blog_id');
    }
}
