<?php

namespace NotificationChannels\ClockworkSms\Exceptions;

class CouldNotSendNotification extends \Exception
{
    public static function serviceRespondedWithAnError($response)
    {
        return new static('Descriptive error message.');
    }

    public static function invalidMessageObject($message)
    {
        if (! $message->getMessage()->getNumber()) {
            $message = 'No number set in the message.';
        } elseif (! $message->getMessage()->getContent()) {
            $message = 'No content set in the message.';
        } else {
            $message = 'The message is not valid.';
        }

        return new static($message);
    }
}
