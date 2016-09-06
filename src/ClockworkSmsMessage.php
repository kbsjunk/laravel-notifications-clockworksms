<?php

namespace NotificationChannels\ClockworkSms;

use MJErwin\Clockwork\ClockworkClient;
use MJErwin\Clockwork\Message;

class ClockworkSmsMessage
{
    /**
     * The underlying client message.
     *
     * @var \MJErwin\Clockwork\Message
     */
    protected $message;

    /**
     * @param string $content
     *
     * @return static
     */
    public static function create()
    {
        return new static();
    }

    /**
     * Create a new message instance.
     *
     * @param  string  $content
     */
    public function __construct()
    {
        $this->message = new Message;
    }

    /**
     * Set the message content.
     *
     * @param  string  $content
     *
     * @return $this
     */
    public function content($content)
    {
        $this->message->setContent($content);

        return $this;
    }

    /**
     * Set the phone number or name the message should be sent from.
     *
     * @param  string  $from
     *
     * @return $this
     */
    public function from($from)
    {
        $this->message->setFromName($from);

        return $this;
    }

    /**
     * Set the phone number the message should be sent to.
     *
     * @param  string  $to
     *
     * @return $this
     */
    public function to($to)
    {
        $this->message->setNumber($to);

        return $this;
    }

    /**
     * Set what to do with any invalid characters in the message content.
     *
     * @param  bool  $truncate
     *
     * @return $this
     */
    public function invalidChars($invalidChars)
    {
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

        $this->message->setInvalidCharAction($invalidChars);

        return $this;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function setMessage(Message $message)
    {
        $this->message = $message;

        return $this;
    }

    public function isValid()
    {
        return $this->getMessage()->getNumber() && $this->getMessage()->getContent();
    }
}
