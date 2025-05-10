<?php

namespace UsmanAhmed\LaravelResponseEncryption;

use Illuminate\Support\ServiceProvider;

class ResponseEncryptionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/response-encryption.php',
            'response-encryption'
        );

        $this->app->singleton('response.encryption', function ($app) {
            return new Services\EncryptionService($app['encrypter']);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/response-encryption.php' => config_path('response-encryption.php'),
        ], 'response-encryption-config');
    }
}