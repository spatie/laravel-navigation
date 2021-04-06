<?php

namespace Spatie\Navigation;

use Illuminate\Support\ServiceProvider;
use Spatie\Navigation\Helpers\ActiveUrlChecker;

class NavigationServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(ActiveUrlChecker::class, function ($app) {
            return new ActiveUrlChecker($app->request->url());
        });

        $this->app->singleton(Navigation::class);
    }
}
