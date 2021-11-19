<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Notifications\Messages\MailMessage;
use Laravel\Passport\Passport;
use app\Models\Blog;
use app\Policies\BlogPolicy;


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

         // call passport:routes() here
            Passport::routes();
        

        VerifyEmail::toMailUsing(function ($notifiable, $url) {
            $spaUrl = "http://spa.test?email_verify_url=".$url;

            return (new MailMessage)
                ->subject('Verify Email Address')
                ->line('Click the button below to verify your email address.')
                ->action('Verify Email Address', $spaUrl);
        });

       
    }
}
