<?php
/**
 * This file is Copyright (c).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SecretBase\AppBundle\Services\Util;

use Swift_Mailer;

class Mailer
{
    /** @var Swift_Mailer */
    private $mailManager;

    public function __construct($mailManager)
    {
        $this->mailManager = $mailManager;
    }

    /**
     * @param $message
     */
    public function send($message)
    {
        $this->mailManager->send($message);
    }

    /**
     * @param $subject
     * @param $from
     * @param $to
     * @param $body
     * @return mixed
     */
    public function createMessage($subject, $from, $to, $body)
    {
        return $this->mailManager->createMessage()
            ->setSubject($subject)
            ->setFrom($from)
            ->setTo($to)
            ->setBody($body)
        ;
    }
}
