<?php

namespace App\Policies;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Http\Request;

class BlogPolicy
{
    use HandlesAuthorization;

    public function delete(User $user,Blog $blog,Request $request)
    {
        return  $blog->users->contains('user_id',$user->id) &&
                $user->email==$request->email && 
                $user->password==$request->password;
    }
}
