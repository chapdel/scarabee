<?php

namespace Chapdel\Scarabee;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Chapdel\scarabee\Observers\QueryObserver;

class ScarabeeServiceProvider extends PackageServiceProvider
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

        $this->app->bind(Scarabee::class, function () {
            $scarabee = new Scarabee();
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
