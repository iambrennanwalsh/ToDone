<?php

namespace App\Mailer;

use App\Mailer\AbstractMailer;

/**
 * This concrete Mailer class is instantiated by the AbstractMailer
 * class that it extends.
 *
 * @author Brennan Walsh
 * @email mail@brennanwal.sh
 * @github https://github.com/iambrennanwalsh
 */
class Mailer extends AbstractMailer
{
    protected function send()
    {
        $response = [
            "status" => true,
            "message" => "Email sent successfully."
        ];
        try {
            $message = (new \Swift_Message())
                ->setSubject($this->getSubject())
                ->setFrom($this->getFrom())
                ->setTo($this->getTo())
                ->setBody(
                    $this->twig->render(
                        $this->getTemplate(),
                        $this->getContent()
                    ),
                    'text/html'
                );
            $this->mailer->send($message);
        } catch (\Exception $e) {
            $response["status"] = false;
            $response["message"] = $e->getMessage();
        }
        return $response;
    }
}
