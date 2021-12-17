<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

  
}
