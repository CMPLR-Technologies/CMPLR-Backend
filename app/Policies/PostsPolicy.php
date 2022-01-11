<?php

namespace App\Policies;

use App\Models\Blog;
use App\Models\BlogUser;
use App\Models\Posts;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\DB;

class PostsPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Posts  $posts
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Posts $posts)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Posts  $posts
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Posts $posts)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Posts  $posts
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Posts $post, Blog $blog)
    {
        return !! BlogUser::where('user_id',$user->id)->where('blog_id',$blog->id)->first();
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Posts  $posts
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Posts $posts)
    {
        //
    }

    public function EditPost(User $user,Posts $post,Blog $blog)
    {
        $check1 = BlogUser::where('user_id',  $user->id)
            ->where('blog_id', $blog->id)->first();

        $check2 = $blog->Posts()->where('id', $post->id)->first();
     
        if ($check1 && $check2)
            return true;
        else
            false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Posts  $posts
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Posts $posts)
    {
        //
    }
}
