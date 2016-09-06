<?php

namespace NotificationChannels\ClockworkSMS;

use NotificationChannels\ClockworkSMS\Exceptions\CouldNotSendNotification;
use NotificationChannels\ClockworkSMS\Events\MessageWasSent;
use NotificationChannels\ClockworkSMS\Events\SendingMessage;
use Illuminate\Notifications\Notification;

class ClockworkSMSChannel
{
    public function __construct()
    {
        // Initialisation code here
    }

    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     *
     * @throws \NotificationChannels\ClockworkSMS\Exceptions\CouldNotSendNotification
     */
    public function send($notifiable, Notification $notification)
    {
        //$response = [a call to the api of your notification send]

//        if ($response->error) { // replace this by the code need to check for errors
//            throw CouldNotSendNotification::serviceRespondedWithAnError($response);
//        }
    }
}
