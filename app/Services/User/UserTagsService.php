<?php

namespace App\Services\User;

use Carbon\Carbon;
use App\Models\Tag;
use App\Models\Posts;
use App\Models\TagUser;
use App\Models\PostTags;
use App\Http\Misc\Helpers\Config;
use Illuminate\Support\Facades\DB;

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
     * This functions gets the tags followed by a user 
     * 
     * @param int $user_id
     * 
     * @return Tag $tags
     * 
     * @author Abdullah Adel
     */
    public function GetFollowedTags(int $userId)
    {
        $tags = TagUser::where(['user_id' => $userId])->with('tag')->get()->pluck('tag');
        // dd($tags->toArray());
        // $followed_tags = [];

        // foreach ($tags as $tag) {
        //     $tag_name = $tag['tag']['name'];
        //     $followed_tags[] = [
        //         'posts_count' => PostTags::where([['tag_name', '=', $tag_name], ['created_at', '>=', Carbon::now()->toDateString()]])->count(),
        //         'tag' => $tag['tag']
        //     ];
        // }

        // return $followed_tags;
        return $tags;
    }

    /**
     * This function gets random tags
     * 
     * @return Tag
     */
    public function GetRandomTags()
    {
        return Tag::select('name')->inRandomOrder()->limit(5)->get()->pluck('name');
    }

    /**
     * This function gets random tags data for explore
     * 
     * @param int $user_id
     * 
     * @return Tag
     * 
     * @author Abdullah Adel
     */
    public function GetRandomTagsData(int $user_id = null)
    {
        $filtered_tags = [];

        if ($user_id) {
            $filtered_tags = DB::table('tag_users')->where('user_id', $user_id)->pluck('tag_name')->toArray();
        }

        return Tag::whereNotIn('name', $filtered_tags)->inRandomOrder()->paginate(Config::PAGINATION_LIMIT);
    }

    /**
     * getting the tag's posts
     * 
     * @return Posts $posts
     */
    public function GetTagPosts($tag_name)
    {
        $postsTags = PostTags::where('tag_name', $tag_name)->orderBy('created_at', 'DESC')->get();
        $posts = Posts::wherein('id', $postsTags->pluck('post_id'))->orderBy('date', 'DESC')->get();
        return $posts;
    }

    /**
     * getting the tag's count of the recent posts
     * 
     * @param Posts $tag_posts
     * 
     * @return integer $recent_posts_count
     * 
     * @author Abdullah Adel
     */
    public function GetTagRecentPostsCount($tag_posts)
    {
        return $tag_posts->where('created_at', '>=', Carbon::now()->toDateString())->count();
    }

    /**
     * getting the tag's number of followers
     * 
     * @param $tag
     * 
     * @return integer $tagsCount
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