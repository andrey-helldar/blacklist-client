<?php

namespace Tests;

use Helldar\BlacklistClient\ServiceProvider;
use Helldar\BlacklistCore\Constants\Server;

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
        $this->setSettings($app);
    }

    protected function getPackageProviders($app)
    {
        return [ServiceProvider::class];
    }

    private function setDatabase($app)
    {
        $app['config']->set('database.default', $this->database);

        $app['config']->set('database.connections.' . $this->database, [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }

    private function setSettings($app)
    {
        $app['config']->set('blacklist_client.server_url', Server::BASE_URL);
        $app['config']->set('blacklist_client.verify_ssl', false);
    }
}
