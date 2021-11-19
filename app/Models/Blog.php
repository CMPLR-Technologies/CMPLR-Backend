<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $fillable =[
        'blog_name',
        'url'
    ];

    public function Followers()
    {
        return $this->hasMany(Follow::class);
    }

    public function FollowedBy(User $user)
    {
        return $this->Followers->contains('user_id',$user->id);
    }

}
