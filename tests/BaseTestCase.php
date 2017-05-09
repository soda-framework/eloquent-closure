<?php

namespace Soda\ClosureTable\Tests;

use DB;
use Event;
use Mockery;
use Way\Tests\ModelHelpers;
use Orchestra\Testbench\TestCase;
use Soda\ClosureTable\Models\Entity;

/**
 * Class BaseTestCase.
 */
abstract class BaseTestCase extends TestCase
{
    use ModelHelpers;

    public static $debug = false;
    public static $sqlite_in_memory = false;

    public function setUp()
    {
        parent::setUp();

        $this->app->bind('Soda\ClosureTable\Contracts\EntityInterface', 'Soda\ClosureTable\Models\Entity');
        $this->app->bind('Soda\ClosureTable\Contracts\ClosureTableInterface', 'Soda\ClosureTable\Models\ClosureTable');

        if (! static::$sqlite_in_memory) {
            DB::statement('DROP TABLE IF EXISTS entities_closure');
            DB::statement('DROP TABLE IF EXISTS entities;');
            DB::statement('DROP TABLE IF EXISTS migrations');
        }

        $artisan = $this->app->make('Illuminate\Contracts\Console\Kernel');
        $artisan->call('migrate', [
            '--database' => 'closuretable',
            '--path'     => '../tests/migrations',
        ]);

        $artisan->call('db:seed', [
            '--class' => 'Soda\ClosureTable\Tests\Seeds\EntitiesSeeder',
        ]);

        if (static::$debug) {
            Entity::$debug = true;
            Event::listen('illuminate.query', function ($sql, $bindings, $time) {
                $sql = str_replace(['%', '?'], ['%%', '%s'], $sql);
                $full_sql = vsprintf($sql, $bindings);
                echo PHP_EOL.'- BEGIN QUERY -'.PHP_EOL.$full_sql.PHP_EOL.'- END QUERY -'.PHP_EOL;
            });
        }
    }

    public function tearDown()
    {
        Mockery::close();
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        // reset base path to point to our package's src directory
        $app['path.base'] = __DIR__.'/../src';

        $app['config']->set('database.default', 'closuretable');

        if (static::$sqlite_in_memory) {
            $options = [
                'driver'   => 'sqlite',
                'database' => ':memory:',
                'prefix'   => '',
            ];
        } else {
            $options = [
                'driver'    => 'mysql',
                'host'      => 'localhost',
                'database'  => 'closuretabletest',
                'username'  => 'root',
                'password'  => '',
                'prefix'    => '',
                'charset'   => 'utf8',
                'collation' => 'utf8_unicode_ci',
            ];
        }

        $app['config']->set('database.connections.closuretable', $options);
    }

    /**
     * Asserts if two arrays have similar values, sorting them before the fact in order to "ignore" ordering.
     * @param array $actual
     * @param array $expected
     * @param string $message
     * @param float $delta
     * @param int $depth
     */
    protected function assertArrayValuesEquals(array $actual, array $expected, $message = '', $delta = 0.0, $depth = 10)
    {
        $this->assertEquals($actual, $expected, $message, $delta, $depth, true);
    }
}
