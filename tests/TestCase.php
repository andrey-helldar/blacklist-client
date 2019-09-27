<?php

namespace Tests;

use Helldar\BlacklistClient\ServiceProvider;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    private $database = 'testing';

    protected function setUp(): void
    {
        parent::setUp();

        $this->loadLaravelMigrations($this->database);

        $this->artisan('migrate', ['--database' => $this->database])->run();
    }

    protected function getEnvironmentSetUp($app)
    {
        $this->setDatabase($app);
    }

    protected function getPackageProviders($app)
    {
        return [ServiceProvider::class];
    }

    private function setDatabase($app)
    {
        $app['config']->set('blacklist_client.server_url', 'http://localhost');

        $app['config']->set('database.default', $this->database);

        $app['config']->set('database.connections.' . $this->database, [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }
}
