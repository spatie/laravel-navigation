<?php

namespace Spatie\Navigation;

use Illuminate\Support\ServiceProvider;
use Spatie\Navigation\Helpers\ActiveUrlChecker;

class NavigationServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(ActiveUrlChecker::class, function () {
            return new ActiveUrlChecker(
                $this->app->request->url(),
                config('app.url')
            );
        });

        $this->app->singleton(Navigation::class);
    }
}
