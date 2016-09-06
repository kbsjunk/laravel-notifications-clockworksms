<?php

namespace NotificationChannels\ClockworkSms;

use Illuminate\Support\ServiceProvider;
use MJErwin\Clockwork\ClockworkClient;

class ClockworkSMSServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->app->when(ClockworkSmsChannel::class)
            ->needs(ClockworkClient::class)
            ->give(function () {
                $apiKey = config('services.clockworksms.key');

                return new ClockworkClient($apiKey);
            });
    }

    /**
     * Register the application services.
     */
    public function register()
    {
    }
}
