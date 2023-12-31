<?php

namespace AppKit\Ui\Tests;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use AppKit\Ui\UiServiceProvider;
use AppKit\Ui\Facades\Ui;

class TestCase extends OrchestraTestCase
{
    /**
     * Setup the test environment
     */
    protected function setUp(): void
    {
        parent::setUp();

        // load the migrations that are used for testing only
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

        // load default laravel migrations?
        // $this->loadLaravelMigrations();

        // load the model factories
        $this->withFactories(__DIR__ . '/database/factories');
    }

    /**
     * Define the service providers
     *
     * @param \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [UiServiceProvider::class];
    }

    /**
     * Define the facades
     *
     * @param \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            'Ui' => Ui::class
        ];
    }

    /**
     * Define environment setup
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }
}
