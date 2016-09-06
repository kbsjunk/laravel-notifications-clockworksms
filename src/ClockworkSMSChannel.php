<?php

namespace NotificationChannels\ClockworkSms;

use NotificationChannels\ClockworkSms\Exceptions\CouldNotSendNotification;
use Illuminate\Notifications\Notification;
use MJErwin\Clockwork\ClockworkClient;

class ClockworkSmsChannel
{
    /**
    * @var \MJErwin\Clockwork\ClockworkClient
    */
    protected $client;

    /**
    * @var \Illuminate\Events\Dispatcher
    */
    private $events;

    public function __construct(ClockworkClient $client Dispatcher $events)
    {
        $this->client = $client;
    }

    /**
    * Send the given notification.
    *
    * @param mixed $notifiable
    * @param \Illuminate\Notifications\Notification $notification
    *
    * @throws \NotificationChannels\ClockworkSms\Exceptions\CouldNotSendNotification
    */
    public function send($notifiable, Notification $notification)
    {
        if (! $to = $notifiable->routeNotificationFor('clockworksms')) {
            if (! $to = $notifiable->phone_number) {
                return;
            }
        }
        try {
            $message = $notification->toClockworkSms($notifiable);
            if (is_string($message)) {
                $message = new ClockworkSmsMessage($message);
            }
            if (! $message instanceof TwilioAbstractMessage) {
                throw CouldNotSendNotification::invalidMessageObject($message);
            }
            if (! $from = $message->from ?: config('services.twilio.from')) {
                throw CouldNotSendNotification::missingFrom();
            }
            return $this->sendMessage($message, $from, $to);
        } catch (Exception $exception) {
            $this->events->fire(
            new NotificationFailed($notifiable, $notification, 'twilio', ['message' => $exception->getMessage()])
        );
    }
    //$response = [a call to the api of your notification send]

    //        if ($response->error) { // replace this by the code need to check for errors
    //            throw CouldNotSendNotification::serviceRespondedWithAnError($response);
    //        }
}
}
