<?php

namespace App\Providers;

use App\Location;
use App\OAuth\SchulCloudProvider;
use App\Policies\EntryPolicy;
use App\Policies\LocationPolicy;
use App\Policies\PortfolioPolicy;
use App\Policies\TagPolicy;
use App\Portfolio;
use App\Tag;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Arr;
use Laravel\Socialite\SocialiteManager;
use Laravel\Socialite\Two\AbstractProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        Portfolio::class => PortfolioPolicy::class,
        Tag::class => TagPolicy::class,
        Location::class => LocationPolicy::class,
    ];

    public function register()
    {
        parent::register();
        $this->registerOAuthProviders();
    }

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }

    private function registerOAuthProviders()
    {
        $this->app->resolving(SocialiteManager::class, function (SocialiteManager $socialite) {
            $socialite->extend('schulcloud', function () {
                return $this->createSchulCloudProvider();
            });
        });
    }

    private function createSchulCloudProvider(): AbstractProvider
    {
        $config = $this->app['config']['services.schulcloud'];

        return new SchulCloudProvider(
            $this->app['request'],
            $config['client_id'],
            $config['client_secret'],
            $config['redirect'],
            Arr::get($config, 'guzzle', []),
            $config['hydra_url']
        );
    }
}
