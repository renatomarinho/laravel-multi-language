<?php
/**
 * Laravel Multi-Language <https://github.com/renatomarinho/laravel-multi-language>.
 *
 * The MIT License (MIT)
 * Copyright (c) 2017 Renato Marinho <renato.marinho@s2move.com>
 */

namespace RenatoMarinho\LaravelMultiLanguage;

use Illuminate\Support\ServiceProvider;

class MultiLanguageServiceProvider extends ServiceProvider
{
    protected $commands = [
        MultiLanguageListCommand::class,
        MultiLanguageUpdateCommand::class,
    ];

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->commands($this->commands);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
