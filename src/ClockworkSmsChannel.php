<?php

namespace NotificationChannels\ClockworkSms;

use NotificationChannels\ClockworkSms\Exceptions\CouldNotSendNotification;
use Illuminate\Notifications\Events\NotificationFailed;
use Illuminate\Notifications\Notification;
use MJErwin\Clockwork\ClockworkClient;
use Exception;

class ClockworkSMSChannel
{
    /**
     * @var \MJErwin\Clockwork\ClockworkClient
     */
    protected $client;

    /**
     * @var \Illuminate\Events\Dispatcher
     */
    private $events;

    public function __construct(ClockworkClient $client, Dispatcher $events)
    {
        $this->client = $client;
        $this->events = $events;
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

            $message = new ClockworkSmsMessage($message);
            $message->to($to);
            $message->from(config('services.clockworksms.from'));
            $message->truncate(config('services.clockworksms.truncate'));
            $message->invalidChars(config('services.clockworksms.invalid_chars'));

            if (! $message->isValid()) {
                throw CouldNotSendNotification::invalidMessageObject($message);
            }

            $response = $this->sendMessage($message);
        } catch (Exception $exception) {
            $this->events->fire(new NotificationFailed($notifiable, $notification, 'clockworksms', ['message' => $exception->getMessage()]));
        }
    }

    /**
     * @param $message
     * @param $from
     * @param $to
     * @return mixed
     *
     * @throws \NotificationChannels\ClockworkSms\Exceptions\CouldNotSendNotification
     */
    protected function sendMessage($message)
    {
        $response = $this->client->sendMessage($message->getMessage());

        if ($response->hasErrors()) {
            throw CouldNotSendNotification::serviceRespondedWithAnError($response);
        }

        return $response;
    }
}
