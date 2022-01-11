<?php

namespace App\Policies;

use App\Models\Blog;
use App\Models\BlogUser;
use App\Models\Posts;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BlogPolicy
{
    use HandlesAuthorization;


    /**
     * Determine whether the blog belongs to the user or not.
     *
     * @param  User  $user
     * @param  Blog  $blog
     * @return bool
     */
    public function BlogBelongsToUser(User $user, Blog $blog)
    {
        $check = BlogUser::where('user_id',  $user->id)
            ->where('blog_id', $blog->id)->first();

        if (!$check)
            return false;
        return true;
    }

    public function delete(User $user, Blog $blog)
    {
        return  $blog->users->contains('id', $user->id) &&
            $blog->users()->where('user_id', $user->id)->where('full_privileges', 'true')->first() != null;
    }
}