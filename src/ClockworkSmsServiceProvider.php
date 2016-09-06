<?php

namespace NotificationChannels\ClockworkSms;

use Illuminate\Support\ServiceProvider;
use MJErwin\Clockwork\ClockworkClient;

class ClockworkSmsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->app->when(ClockworkSmsChannel::class)
        ->needs(ClockworkClient::class)
        ->give(function () {
            $client = new ClockworkClient(config('services.clockworksms.key'));

            if ($truncate = config('services.clockworksms.truncate')) {
                $client->setTruncateEnabled($truncate);
            }

            $invalidChars = config('services.clockworksms.invalid_chars');

            switch ($invalidChars) {
                case 'error':
                $invalidChars = ClockworkClient::INVALID_CHAR_ACTION_RETURN_ERROR;
                break;
                case 'remove':
                $invalidChars = ClockworkClient::INVALID_CHAR_ACTION_REMOVE_CHARS;
                break;
                case 'replace':
                $invalidChars = ClockworkClient::INVALID_CHAR_ACTION_REPLACE_CHARS;
                break;
                default:
                $invalidChars = null;
            }

            if ($invalidChars) {
                $client->setInvalidCharAction($invalidChars);
            }

            return $client;
        });
    }

    /**
     * Register the application services.
     */
    public function register()
    {
    }
}
