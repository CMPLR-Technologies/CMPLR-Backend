<?php

use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\ForgetPasswordController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BlogSettingsController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\PostNotesController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UploadMediaController;
use App\Http\Controllers\UserBlogController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserPostConroller;
use App\Http\Controllers\UsersettingController;
use App\Http\Controllers\AskController;
use App\Http\Controllers\BlogSubmitController;
use App\Http\Controllers\BlogBlockController;
use App\Http\Controllers\InboxController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\BlogChatController;
use App\Http\Controllers\UsertagsConroller;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Post Notes
Route::get('post/notes', [PostNotesController::class, 'getNotes']);

// Post Tags
Route::get('post/tagged', [PostsController::class, 'GetTaggedPosts']);
Route::get('tag/info', [UserTagsConroller::class, 'GetTagInfo']);

// Search
Route::get('search/{query}', [SearchController::class, 'search']);

// Auth
Route::post('login', [LoginController::class, 'Login']);

Route::post('register/insert', [RegisterController::class, 'Register']);
Route::post('register/validate', [RegisterController::class, 'ValidateRegister']);

Route::post('forgot_password', [ForgetPasswordController::class, 'ForgetPassword']);

Route::get('reset_password/{token}', [ResetPasswordController::class, 'GetResetPassword']);
Route::post('reset_password', [ResetPasswordController::class, 'ResetPassword']);

// Google
Route::get('auth/google', [GoogleController::class, 'GoogleLogin'])->middleware('web');
Route::any('auth/callback', [GoogleController::class, 'handleGoogleCallback'])->middleware('web');

Route::post('google/signup', [GoogleController::class, 'SignUpWithGoogle']);
Route::post('google/login', [GoogleController::class, 'GetUserFromGoogle']);

// Explore
Route::get('recommended/tags', [UserTagsConroller::class, 'GetRecommendedTags']);
Route::get('recommended/blogs', [BlogController::class, 'GetRecommendedBlogs']);
Route::get('recommended/posts', [PostsController::class, 'GetRecommendedPosts']);

Route::get('trending/tags', [UserTagsConroller::class, 'GetTrendingTags']);
Route::get('trending/blogs', [BlogController::class, 'GetTrendingBlogs']);
Route::get('trending/posts', [PostsController::class, 'GetTrendingPosts']);

Route::group(function () {
    // Chat
    Route::get('blog/messaging/{blogId}', [BlogChatController::class, 'GetMessages']);
    Route::get('messaging/conversation/{blogIdFrom}/{blogIdTo}', [BlogChatController::class, 'Conversation']);
    Route::post('messaging/conversation/{blogIdFrom}/{blogIdTo}', [BlogChatController::class, 'SendMessage']);
    Route::delete('messaging/conversation/{blogIdFrom}/{blogIdTo}', [BlogChatController::class, 'DeleteMessgaes']);

    // Post Notes
    Route::post('user/post/reply', [UserPostConroller::class, 'UserReply']);
    Route::post('user/like', [UserPostConroller::class, 'Like']);
    Route::delete('user/unlike', [UserPostConroller::class, 'UnLike']);

    // Post Tags
    Route::post('user/tags/add', [UsertagsConroller::class, 'FollowTag']);
    Route::delete('user/tags/remove', [UsertagsConroller::class, 'UnFollowTag']);

    // Follow/Unfollow Blog
    Route::post('user/follow', [UserBlogController::class, 'follow']);
    Route::delete('user/follow', [UserBlogController::class, 'unfollow']);

    // Get/Create/Delete Blog
    Route::get('blog/{blogId}/info', [UserBlogController::class, 'GetBlogInfo']);
    Route::post('blog', [UserBlogController::class, 'create']);
    Route::post('blog/{blogName}', [UserBlogController::class, 'destroy']);

    // Auth
    Route::get('verify-email/{id}/{hash}', [EmailVerificationController::class, 'Verify']);
    Route::post('logout', [LoginController::class, 'Logout']);
    Route::post('email/verification-notification', [EmailVerificationController::class, 'SendVerificationEmail']);

    // Blog Settings
    Route::get('blog/{blog_name}/settings', [BlogSettingsController::class, 'getBlogSettings']);
    Route::put('blog/{blog_name}/settings/save', [BlogSettingsController::class, 'saveBlogSettings']);

    // User Settings
    Route::get('user/settings', [UsersettingController::class, 'AccountSettings']);
    Route::put('user/settings', [UsersettingController::class, 'UpdateSettings']);
    Route::put('settings/change_email', [UsersettingController::class, 'ChangeEmail']);
    Route::put('settings/change_password', [UsersettingController::class, 'ChangePassword']);

    // User Info
    Route::get('user/info', [UserController::class, 'GetUserInfo']);
    Route::get('user/likes', [UserController::class, 'GetUserLikes']);
    Route::get('user/followings', [UserBlogController::class, 'GetUserFollowing']);
    Route::get('following/tags', [UserTagsConroller::class, 'GetFollowedTags']);

    // Blogs Followers
    Route::get('blog/{blog_name}/followers', [BlogController::class, 'GetFollowers']);

    // User Theme
    Route::get('user_theme', [UserController::class, 'GetUserTheme']);
    Route::put('user_theme', [UserController::class, 'UpdateUserTheme']);

    // Ask
    Route::post('blog/{blogName}/ask', [AskController::class, 'CreateAsk']);
    Route::post('ask/{askId}', [AskController::class, 'AnswerAsk']);
    Route::delete('ask/{askId}', [AskController::class, 'DeleteAsk']);

    // Inbox
    Route::get('user/inbox', [InboxController::class, 'GetInbox']);
    Route::get('user/inbox/{blogName}', [InboxController::class, 'GetBlogInbox']);
    Route::delete('user/inbox/', [InboxController::class, 'DeleteInbox']);
    Route::delete('user/inbox/{blogName}', [InboxController::class, 'DeleteBlogInbox']);

    // Posts
    Route::get('posts/radar/', [PostsController::class, 'GetRadar']);
    Route::get('posts/{post_id}', [PostsController::class, 'GetPostById']);
    Route::get('edit/{blog_name}/{post_id}', [PostsController::class, 'edit']);
    Route::get('user/dashboard/', [UserController::class, 'GetDashboard']);
    Route::get('MiniProfileView/{blog_id}', [PostsController::class, 'MiniProfileView']);
    Route::middleware('guest')->get('posts/view/{blog_name}', [PostsController::class, 'GetBlogPosts']);
    Route::post('posts', [PostsController::class, 'create']);
    Route::put('update/{blog_name}/{post_id}', [PostsController::class, 'update']);
    Route::delete('post/delete/{post_id}', [PostsController::class, 'destroy']);
    Route::delete('user/likes', [PostsController::class, 'GetUserLikes']);

    // Upload
    Route::post('image_upload', [UploadMediaController::class, 'UploadImagesaa']);
    Route::post('video_upload', [UploadMediaController::class, 'UploadVideos']);
    Route::post('base64image_upload', [UploadMediaController::class, 'UploadBase64Image']);

    // Submit
    Route::post('blog/{blogName}/submit', [BlogSubmitController::class, 'CreateSubmit']);
    Route::post('submit/{submId}', [BlogSubmitController::class, 'PostSubmit']);
    Route::delete('submit/{submitId}', [BlogSubmitController::class, 'DeleteSubmit']);

    // Block
    Route::get('blog/{blogName}/blocks', [BlogBlockController::class, 'GetBlogBlocks']);
    Route::post('blog/{blogName}/blocks', [BlogBlockController::class, 'BlockBlog']);
    Route::delete('blog/{blogName}/blocks', [BlogBlockController::class, 'UnblockBlog']);

    // Notifications
    Route::get('blog/{blogName}/notifications', [NotificationsController::class, 'GetNotifications']);
    Route::get('notifications/unseens', [NotificationsController::class, 'GetUnseens']);
    Route::get('blog/{blogName}/last-ndays-activity', [NotificationsController::class, 'GetLastNdaysActivity']);
    // Route::get('notifications', [NotificationsController::class, 'GetNotifications']);
    Route::post('notifications/store-token', [NotificationsController::class, 'StoreToken']);
    Route::put('notifications/{notificationId}/see', [NotificationsController::class, 'SeeNotification']);

    // Profile Info
    Route::get('profile/likes/{blog_name}', [PostsController::class, 'ProfileLikes']);
    Route::get('profile/following/{blog_name}', [PostsController::class, 'ProfileFollowing']);
});