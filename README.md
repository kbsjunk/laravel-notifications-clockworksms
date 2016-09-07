# Clockwork SMS channel for Laravel 5.3 Notifications

[![Latest Version on Packagist](https://img.shields.io/packagist/v/laravel-notification-channels/clockworksms.svg?style=flat-square)](https://packagist.org/packages/laravel-notification-channels/clockworksms)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/laravel-notification-channels/clockworksms/master.svg?style=flat-square)](https://travis-ci.org/laravel-notification-channels/clockworksms)
[![StyleCI](https://styleci.io/repos/67546442/shield)](https://styleci.io/repos/67546442)
[![SensioLabsInsight](https://img.shields.io/sensiolabs/i/bbddee44-1912-45cf-8f70-6b08baa591c2.svg?style=flat-square)](https://insight.sensiolabs.com/projects/bbddee44-1912-45cf-8f70-6b08baa591c2)
[![Quality Score](https://img.shields.io/scrutinizer/g/laravel-notification-channels/clockworksms.svg?style=flat-square)](https://scrutinizer-ci.com/g/laravel-notification-channels/clockworksms)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/laravel-notification-channels/clockworksms/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/laravel-notification-channels/clockworksms/?branch=master)
[![Total Downloads](https://img.shields.io/packagist/dt/laravel-notification-channels/clockworksms.svg?style=flat-square)](https://packagist.org/packages/laravel-notification-channels/clockworksms)

This package makes it easy to send notifications using [Clockwork SMS](https://www.clockworksms.com) with Laravel 5.3.

***Important! This package is a work in progress and is not complete. It is not ready for development or production.***

## Contents

- [Installation](#installation)
	- [Setting up the Clockwork SMS service](#setting-up-the-clockwork-sms-service)
- [Usage](#usage)
	- [Available Message methods](#available-message-methods)
- [Changelog](#changelog)
- [Testing](#testing)
- [Security](#security)
- [Contributing](#contributing)
- [Credits](#credits)
- [License](#license)


## Installation

You can install the package via composer:

``` bash
composer require laravel-notification-channels/clockworksms
```

You must install the service provider:

```php
// config/app.php
'providers' => [
    ...
    NotificationChannels\ClockworkSms\ClockworkSmsServiceProvider::class,
],
```

### Setting up the Clockwork SMS service

Add your Clockwork SMS API Key, From Number and other options (optional) to your `config/services.php` and `.env` files:

```php
// config/services.php
...
'clockworksms' => [
    'key' => env('CLOCKWORKSMS_KEY'),
    'from' => env('CLOCKWORKSMS_FROM'), // optional, uses account default if null
    'truncate' => null, // optional, uses account default if null: true, false
    'invalid_chars' => null, // optional, uses account default if null: 'error', 'remove', 'replace'
],
...
```

See the documentation on [invalidcharaction](https://www.clockworksms.com/doc/clever-stuff/xml-interface/send-sms/#invalidcharaction) for details about how this behaves.

## Usage

Now you can use the channel in your `via()` method inside the notification:

``` php
use NotificationChannels\ClockworkSms\ClockworkSmsChannel;
use NotificationChannels\ClockworkSms\ClockworkSmsMessage;
use Illuminate\Notifications\Notification;

class AccountApproved extends Notification
{
    public function via($notifiable)
    {
        return [ClockworkSmsChannel::class];
    }

    public function toClockworkSms($notifiable)
    {
        return (new ClockworkSmsMessage())
            ->content("Your account was approved!");
    }
}
```

In order to let your Notification know which phone are you sending to, the channel will look for the `phone_number` attribute of the Notifiable model. If you want to override this behaviour, add the `routeNotificationForClockworkSms` method to your Notifiable model.

```php
public function routeNotificationForClockworkSms()
{
    return $this->mobile_telephone;
}
```

### Available methods

#### ClockworkSmsMessage

- `to(string $to)`: Accepts a phone number to use as the notification recipient. ([Documentation](https://www.clockworksms.com/doc/clever-stuff/xml-interface/send-sms/#to))
- `from(string $from)`: Accepts a phone number or name to use as the notification sender. ([Documentation](https://www.clockworksms.com/doc/clever-stuff/xml-interface/send-sms/#from))
- `content(string $content)`: Accepts a string value for the notification body. ([Documentation](https://www.clockworksms.com/doc/clever-stuff/xml-interface/send-sms/#content))

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Security

If you discover any security related issues, please email mail@kitbs.com instead of using the issue tracker.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Kitbs](https://github.com/kitbs)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
