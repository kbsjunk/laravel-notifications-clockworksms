<?php
/**
 * Clockwork PHP API.
 *
 * @copyright   Mediaburst Ltd 2012
 * @license     MIT
 * @link        http://www.clockworksms.com
 */
namespace NotificationChannels\ClockworkSMS\Exceptions;

use Exception;

/*
 * ClockworkException
 *
 * The Clockwork wrapper class will throw these if a general error
 * occurs with your request, for example, an invalid API key.
 *
 * @package     Clockwork
 * @subpackage  Exception
 * @since       1.0
 */
class ClockworkSMSException extends Exception
{
    public function __construct($message, $code = 0)
    {
        // make sure everything is assigned properly
        parent::__construct($message, $code);
    }
}