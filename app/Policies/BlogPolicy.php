<?php

namespace App\Policies;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BlogPolicy
{
    use HandlesAuthorization;

    public function delete(User $user, Blog $blog)
    {
        return  $blog->users->contains('user_id', $user->id) &&
            $blog->users->where('user_id', $user->id)->first()->full_privileges == true;
    }
}