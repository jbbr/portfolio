<?php

namespace App\Providers;

use App\Location;
use App\Policies\EntryPolicy;
use App\Policies\LocationPolicy;
use App\Policies\PortfolioPolicy;
use App\Policies\TagPolicy;
use App\Portfolio;
use App\Tag;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

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

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
