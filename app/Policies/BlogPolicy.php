<?php

namespace App\Policies;

use App\Models\Blog;
use App\Models\BlogUser;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BlogPolicy
{
    use HandlesAuthorization;


    /**
     * Determine whether the user can view the followers of blog or not.
     *
     * @param  User  $user
     * @param  Post  $post
     * @return bool
     */
    public function ViewFollowers(User $user, Blog $blog)
    {
        // user of the blog is the only one that can view the followers
        $check = BlogUser::where('user_id',  $user->id)
                        ->where('blog_id', $blog->id)->first();

        if (!$check)
            return false;
        return true;
    }

    public function delete(User $user, Blog $blog)
    {
        return  $blog->users->contains('user_id', $user->id) &&
            $blog->users->where('user_id', $user->id)->first()->full_privileges == true;
    }
}
