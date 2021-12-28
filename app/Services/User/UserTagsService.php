<?php

namespace App\Services\User;

use App\Models\Tag;
use App\Models\TagUser;
use App\Http\Misc\Helpers\Config;
use App\Models\PostTags;

class UserTagsService
{
    /*
     |--------------------------------------------------------------------------
     | UserTagsService
     |--------------------------------------------------------------------------|
     | This Service handles all UserTags controller needed 
     |
     */
    /**
     * user follow tag 
     * 
     * @param $tagName
     * @param integer $userId 
     *
     * @return bool 
     * @author Yousif Ahmed 
     */
    public function UserFollowTag($tagName, $userId): bool
    {
        try {
            TagUser::Create([
                'tag_name' => $tagName,
                'user_id' =>  $userId,
            ]);
        } catch (\Throwable $th) {
            return false;
        }
        return true;
    }

    /**
     * user unfollow tag 
     * 
     * @param $tagName
     * @param integer $userId 
     *
     * @return bool 
     * @author Yousif Ahmed 
     */
    public function UserUnFollowTag($tagName, $userId): bool
    {
        try {
            TagUser::where(['user_id' => $userId, 'tag_name' => $tagName])->delete();
        } catch (\Throwable $th) {
            return false;
        }
        return true;
    }

    /**
     * getting random tags 
     * 
     * @return $tags
     */
    public function GetRandomTags()
    {
        return Tag::select('name')->inRandomOrder()->limit(5)->get()->pluck('name');
    }

    /**
     * getting random tags data
     * 
     * @return $tags
     */
    public function GetRandomTagsData()
    {
        return Tag::inRandomOrder()->paginate(Config::PAGINATION_LIMIT);
    }

    /**
     * getting the tag's posts
     * 
     * @return $posts
     */
    public function GetTagPosts($tag_name)
    {
        $post = PostTags::where('tag_name', '=', $tag_name)->with('post');

        if (!$post) {
            return [];
        }

        return $post;
    }

    /**
     * getting random tags 
     * 
     * @param $tag
     * 
     * @return $tagscount
     */
    public function GetTotalTagsFollowers($tag)
    {
        return TagUser::where('tag_name', $tag)->count();
    }
    /**
     * check user follow tag
     * 
     * @param $tag
     * 
     * @return boolean 
     */
    public function IsFollower($tag)
    {
        $user = auth('api')->user();
        if ($user)
            return (TagUser::where(['user_id' => $user->id, 'tag_name' => $tag])->first()) ? true : false;


        return  false;
    }
}