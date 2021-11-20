<?php

namespace App\Providers;

use app\Models\Blog;
use App\Models\BlogUser;
use app\Policies\BlogPolicy;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\Model' => 'App\Policies\ModelPolicy',
        Blog::class => BlogPolicy::class,
    ];

    /**
     * we call the passport: routes 
     * to register routes that our application will use * to issue tokens and clients
     * 
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Only authorize the authenticated user to control his own blog settings 
        Gate::define('control-settings', function ($user, $blog) {
            $blogUsers = BlogUser::where('user_id', $user->id)->get();

            foreach ($blogUsers as $blogUser) {
                if ($blogUser->blog_id == $blog->id) {
                    return true;
                }
            }
            return false;
        });

        // call passport:routes() here
        Passport::routes();

        VerifyEmail::toMailUsing(function ($notifiable, $url) {
            $spaUrl = "http://spa.test?email_verify_url=" . $url;

            return (new MailMessage)
                ->subject('Verify Email Address')
                ->line('Click the button below to verify your email address.')
                ->action('Verify Email Address', $spaUrl);
        });
    }
}