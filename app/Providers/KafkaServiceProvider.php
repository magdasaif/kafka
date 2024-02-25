<?php

namespace App\Providers;

use App\Kafka\Consumer;
use App\Kafka\Producer;
use Illuminate\Support\ServiceProvider;

class KafkaServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // $this->app->singleton(Consumer::class, function () {
        //     return new Consumer();
        // });

        // $this->app->singleton(Producer::class, function () {
        //     return new Producer();
        // });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
