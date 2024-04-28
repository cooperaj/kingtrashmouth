<?php

declare(strict_types=1);

namespace App\Providers;

use App\Racoon\RacoonInterface;
use App\Racoon\UnsplashRacoon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(RacoonInterface::class, function(Application $app) {
            return new UnsplashRacoon(
                config('racoon.unsplash_access_key'),
                $app->get('image'),
            );
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array<int, string>
     */
    public function provides(): array
    {
        return [RacoonInterface::class];
    }
}
