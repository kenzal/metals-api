<?php

namespace Kenzal\MetalsApi\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Kenzal\MetalsApi\MetalsApiServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Kenzal\\MetalsApi\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            MetalsApiServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        /*
        $migration = include __DIR__.'/../database/migrations/create_metals-api_table.php.stub';
        $migration->up();
        */
    }
}
