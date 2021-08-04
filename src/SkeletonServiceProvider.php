<?php

namespace Chapdel\scarabee;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Chapdel\scarabee\Commands\scarabeeCommand;
use Chapdel\scarabee\Observers\QueryObserver;

class scarabeeServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('scarabee')
            ->hasConfigFile()
            ->hasViews();

        $this->app->bind(scarabee::class, function () {
            $scarabee = new scarabee();
            $scarabee->checkActive();

            return $scarabee;
        });

        $this->app->bind(QueryObserver::class, function () {
            $observer = new QueryObserver();
            $observer->register();

            return $observer;
        });
    }
}
