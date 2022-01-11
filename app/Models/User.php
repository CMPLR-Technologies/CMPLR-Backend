<?php

namespace App\Models;

use App\Models\BlogUser;
use App\Models\Follow;
use App\Models\Tag;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
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
        'email_verified_at',
        'fcm_token'
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

    // returns the BlogUser rows related to this user
    public function blogs()
    {
        return $this->hasMany(BlogUser::class);
    }


    // returns the blogs belong to this user
    public function realBlogs()
    {
        return $this->belongsToMany(Blog::class,'blog_users');
    }

    public function notes()
    {
        return $this->hasMany(PostNotes::class);
    }

    public function FollowedBlogs()
    {
        return $this->belongsToMany(Blog::class ,'follows', 'user_id', 'blog_id');
    }

    public function LikesCount()
    {
        return PostNotes::where('user_id',$this->id)->where('type','=','like')->count();
    }

    
    public function FollowCount()
    {
        return DB::table('follows')->where('user_id',$this->id)->count();
    }

    public function PrimaryBlogInfo()
    {
        return $this->hasOne(Blog::class , 'id' , 'primary_blog_id');
    }

}
