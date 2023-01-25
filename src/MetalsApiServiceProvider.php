<?php

namespace Kenzal\MetalsApi;

use Illuminate\Contracts\Support\DeferrableProvider;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class MetalsApiServiceProvider extends PackageServiceProvider implements DeferrableProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('metals-api')
            ->hasConfigFile();
    }
}
