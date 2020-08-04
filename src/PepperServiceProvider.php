<?php

namespace Pepper;

use Illuminate\Support\ServiceProvider;
use Pepper\Commands\TypeCommand;
use Pepper\Commands\QueryCommand;
use Pepper\Commands\InputCommand;
use Pepper\Commands\OrderCommand;
use Pepper\Commands\MutationCommand;
use Pepper\Commands\AddCommand;

class PepperServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/pepper.php' => config_path('pepper.php'),
        ], 'config');

        $this->publishes([
            __DIR__ . '/../resources/lang' => "{$this->app['path.lang']}/vendor/pepper",
        ]);

        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang/', 'pepper');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/pepper.php', 'pepper');

        $this->app->register(\Rebing\GraphQL\GraphQLServiceProvider::class);

        $this->app->bind('command.pepper:queries', QueryCommand::class);
        $this->app->bind('command.pepper:types', TypeCommand::class);
        $this->app->bind('command.pepper:inputs', InputCommand::class);
        $this->app->bind('command.pepper:orders', OrderCommand::class);
        $this->app->bind('command.pepper:mutations', MutationCommand::class);
        $this->app->bind('command.pepper:add', AddCommand::class);

        $this->commands([
            'command.pepper:queries',
            'command.pepper:types',
            'command.pepper:inputs',
            'command.pepper:orders',
            'command.pepper:mutations',
            'command.pepper:add',
        ]);
    }
}
