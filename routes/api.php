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
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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

// Chat 
Route::get('/blog/messaging/{blogId}', [BlogChatController::class, 'GetMessages'])->middleware('auth:api');
Route::get('/messaging/conversation/{blogIdFrom}/{blogIdTo}', [BlogChatController::class, 'Conversation'])->middleware('auth:api');
Route::post('/messaging/conversation/{blogIdFrom}/{blogIdTo}', [BlogChatController::class, 'SendMessage'])->middleware('auth:api');
Route::delete('/messaging/conversation/{blogIdFrom}/{blogIdTo}', [BlogChatController::class, 'DeleteMessgaes'])->middleware('auth:api');

// PostNotes 
Route::get('post/notes', [PostNotesController::class, 'getNotes']);
Route::post('user/like', [UserPostConroller::class, 'Like'])->middleware('auth:api');
Route::delete('user/unlike', [UserPostConroller::class, 'UnLike'])->middleware('auth:api');
Route::post('/user/post/reply', [UserPostConroller::class, 'UserReply'])->middleware('auth:api');

//postTags 
Route::post('user/tags/add', [UsertagsConroller::class, 'FollowTag'])->middleware('auth:api');
Route::delete('user/tags/remove', [UsertagsConroller::class, 'UnFollowTag'])->middleware('auth:api');
Route::get('post/tagged', [PostsController::class, 'GetTaggedPosts']);
Route::get('tag/info', [UserTagsConroller::class, 'GetTagInfo']);

// Search
Route::get('search/{query}', [SearchController::class, 'search']);

// Follow/Unfollow blog
Route::post('/user/follow', [UserBlogController::class, 'follow'])->middleware('auth:api');
Route::delete('/user/follow', [UserBlogController::class, 'unfollow'])->middleware('auth:api');

// Create/Delete blog
Route::post('/blog', [UserBlogController::class, 'create'])->middleware('auth:api');
Route::post('/blog/{blogName}', [UserBlogController::class, 'destroy'])->middleware('auth:api');
Route::get('/blog/{blogId}/info', [UserBlogController::class, 'GetBlogInfo'])->middleware('auth:api');

Route::post('/register/insert', [RegisterController::class, 'Register'])->name('Register');
Route::post('/register/validate', [RegisterController::class, 'ValidateRegister'])->name('ValidateRegister')->middleware('cors:api');
Route::post('/forgot_password', [ForgetPasswordController::class, 'ForgetPassword'])->name('password.email');
Route::post('/reset_password', [ResetPasswordController::class, 'ResetPassword'])->name('password.reset');
Route::get('/reset_password/{token}', [ResetPasswordController::class, 'GetResetPassword'])->name('password.reset.get');

Route::post('/login', [LoginController::class, 'Login']);
Route::post('/logout', [LoginController::class, 'Logout'])->middleware('auth:api');
Route::post('email/verification-notification', [EmailVerificationController::class, 'SendVerificationEmail'])->name('verification.send')->middleware('auth:api');
Route::get('verify-email/{id}/{hash}', [EmailVerificationController::class, 'Verify'])->middleware(['auth', 'signed'])->name('verification.verify');

// Settings routes
Route::middleware('auth:api')->group(function () {
    Route::get('blog/{blog_name}/settings', [BlogSettingsController::class, 'getBlogSettings'])->name('getBlogSettings');
    Route::put('blog/{blog_name}/settings/save', [BlogSettingsController::class, 'saveBlogSettings'])->name('saveBlogSettings');

    Route::get('user/info', [UserController::class, 'GetUserInfo'])->name('GetUser_Info');

    Route::get('/user/settings', [UsersettingController::class, 'AccountSettings'])->name('GetAccountSetting');
    Route::put('user/settings', [UsersettingController::class, 'UpdateSettings'])->name('UpdateAccountSetting');
    Route::put('/settings/change_email', [UsersettingController::class, 'ChangeEmail'])->name('Change Email');
    Route::put('/settings/change_password', [UsersettingController::class, 'ChangePassword'])->name('Change Password');
});

// Blogs
Route::middleware(['auth:api'])->group(function () {
    Route::get('/blog/{blog_name}/followers', [BlogController::class, 'GetFollowers'])->name('GetBlogFollowers');
});

Route::middleware(['auth:api'])->get('/user_theme', [UserController::class, 'GetUserTheme'])->name('Getuser_theme');
Route::middleware(['auth:api'])->put('/user_theme', [UserController::class, 'UpdateUserTheme'])->name('updateuser_theme');

// Google
Route::get('auth/google', [GoogleController::class, 'GoogleLogin'])->middleware('web');
Route::any('auth/callback', [GoogleController::class, 'handleGoogleCallback'])->middleware('web');

Route::post('google/signup', [GoogleController::class, 'SignUpWithGoogle']);
Route::post('google/login', [GoogleController::class, 'GetUserFromGoogle']);

// Ask
Route::post('/blog/{blogName}/ask', [AskController::class, 'CreateAsk'])->middleware('auth:api');
Route::post('/ask/{askId}', [AskController::class, 'AnswerAsk'])->middleware('auth:api');
Route::delete('/ask/{askId}', [AskController::class, 'DeleteAsk'])->middleware('auth:api');

// Inbox
Route::get('/user/inbox', [InboxController::class, 'GetInbox'])->middleware('auth:api');
Route::get('/user/inbox/{blogName}', [InboxController::class, 'GetBlogInbox'])->middleware('auth:api');
Route::delete('/user/inbox/', [InboxController::class, 'DeleteInbox'])->middleware('auth:api');
Route::delete('/user/inbox/{blogName}', [InboxController::class, 'DeleteBlogInbox'])->middleware('auth:api');


// Posts
Route::middleware('auth:api')->group(function () {
    Route::post('/posts', [PostsController::class, 'create'])->name('CreatePost');
    Route::get('edit/{blog_name}/{post_id}', [PostsController::class, 'edit'])->name('EditPost');
    Route::put('update/{blog_name}/{post_id}', [PostsController::class, 'update'])->name('UpdatePost');
    Route::get('posts/radar/', [PostsController::class, 'GetRadar'])->name('post.get.radar');
    Route::delete('post/delete/{post_id}', [PostsController::class, 'destroy'])->name('post.delete');
    Route::delete('user/likes', [PostsController::class, 'GetUserLikes'])->name('post.GetUserLikes');
});
Route::get('user/dashboard/', [UserController::class, 'GetDashboard'])->name('Get.Dashboard');
Route::get('posts/{post_id}', [PostsController::class, 'GetPostById'])->name('post.get.id');
Route::middleware('guest')->get('posts/view/{blog_name}', [PostsController::class, 'GetBlogPosts'])->name('post.get.blogs');
Route::get('MiniProfileView/{blog_id}', [PostsController::class, 'MiniProfileView'])->name('post.get.MiniProfileView');

// Explore
Route::get('/recommended/tags', [UserTagsConroller::class, 'GetRecommendedTags'])->name('recommended.tags');
Route::get('/recommended/blogs', [BlogController::class, 'GetRecommendedBlogs'])->name('recommended.blogs');
Route::get('/recommended/posts', [PostsController::class, 'GetRecommendedPosts'])->name('recommended.posts');

Route::get('/trending/tags', [UserTagsConroller::class, 'GetTrendingTags'])->name('trending.tags');
Route::get('/trending/blogs', [BlogController::class, 'GetTrendingBlogs'])->name('trending.blogs');
Route::get('/trending/posts', [PostsController::class, 'GetTrendingPosts'])->name('trending.posts');

// Upload
Route::middleware('auth:api')->post('/image_upload', [UploadMediaController::class, 'UploadImagesaa'])->name('image.upload.post');
Route::middleware('auth:api')->post('video_upload', [UploadMediaController::class, 'UploadVideos'])->name('Videos.upload.post');
Route::middleware('auth:api')->post('base64image_upload', [UploadMediaController::class, 'UploadBase64Image'])->name('Base64Image.upload.post');

// Submit
Route::post('/blog/{blogName}/submit', [BlogSubmitController::class, 'CreateSubmit'])->middleware('auth:api');
Route::post('/submit/{submId}', [BlogSubmitController::class, 'PostSubmit'])->middleware('auth:api');
Route::delete('/submit/{submitId}', [BlogSubmitController::class, 'DeleteSubmit'])->middleware('auth:api');

// Block
Route::post('/blog/{blogName}/blocks', [BlogBlockController::class, 'BlockBlog'])->middleware('auth:api');
Route::delete('/blog/{blogName}/blocks', [BlogBlockController::class, 'UnblockBlog'])->middleware('auth:api');
Route::get('/blog/{blogName}/blocks', [BlogBlockController::class, 'GetBlogBlocks'])->middleware('auth:api');

// Notification
Route::get('/blog/{blogName}/notifications', [NotificationsController::class, 'GetNotifications'])->middleware('auth:api');
Route::put('/notifications/{notificationId}/see', [NotificationsController::class, 'SeeNotification'])->middleware('auth:api');
// Route::get('/notifications', [NotificationsController::class, 'GetNotifications'])->middleware('auth:api');
Route::get('/notifications/unseens', [NotificationsController::class, 'GetUnseens'])->middleware('auth:api');
Route::post('/notifications/store-token', [NotificationsController::class, 'StoreToken'])->middleware('auth:api');
Route::get('/blog/{blogName}/last-ndays-activity', [NotificationsController::class, 'GetLastNdaysActivity'])->middleware('auth:api');

// User 
Route::middleware('auth:api')->get('/user/likes', [UserController::class, 'GetUserLikes'])->name('GetUserLikes');
Route::middleware('auth:api')->get('/user/followings', [UserBlogController::class, 'GetUserFollowing'])->name('Get.User.Following');

// profile
Route::middleware('auth:api')->get('profile/likes/{blog_name}', [PostsController::class, 'ProfileLikes'])->name('Get.ProfileLikes');
Route::middleware('auth:api')->get('profile/following/{blog_name}', [PostsController::class, 'ProfileFollowing'])->name('Get.ProfileFollowing');