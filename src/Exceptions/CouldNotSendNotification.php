<?php

namespace NotificationChannels\ClockworkSms\Exceptions;

use NotificationChannels\ClockworkSms\ClockworkSmsMessage;

class CouldNotSendNotification extends \Exception
{
    public static function serviceRespondedWithAnError($response)
    {
        $code = $response->getErrorCode();
        $description = $response->getErrorDescription();

        return new static("Error {$code}: $description");
    }

    public static function invalidMessageObject($message)
    {
        if ($message instanceof ClockworkSmsMessage) {
            if (! $message->getMessage()->getNumber()) {
                $message = 'Notification was not sent. No number set in the message.';
            } elseif (! $message->getMessage()->getContent()) {
                $message = 'Notification was not sent. No content set in the message.';
            } else {
                $message = 'Notification was not sent. Message is invalid.';
            }
        } else {
            $className = get_class($message) ?: 'Unknown';
            $message = "Notification was not sent. Message object class `{$className}` is invalid. It must be `".ClockworkSmsMessage::class.'`.';
        }

        return new static($message);
    }
}
