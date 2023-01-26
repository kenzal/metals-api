<?php

namespace Kenzal\MetalsApi\Tests;

use Kenzal\MetalsApi\MetalsApiServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            MetalsApiServiceProvider::class,
        ];
    }

    /**
     * Override application aliases.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return array<string, class-string<\Illuminate\Support\Facades\Facade>>
     */
    protected function getPackageAliases($app)
    {
        return [
            'MetalsApi' => 'Kenzal\MetalsApi',
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('metalsApi', [
            'access_key' => 'RandomAccessKey',
            'host' => 'http://localhost',
            'base' => env('METALS_API_BASE', 'USD'),
        ]);
    }
}
