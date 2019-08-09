<?php

namespace App\Mailer;

use Twig\Environment;

/**
 * This abstract class instantiates the concrete Mailer class that
 * extends this class. In the dev enviroment the email recipent is
 * defined globally within the dev swiftmailer.yaml config file.
 * The global from email address is defined in services.yaml, and
 * passed as an argument into this class.
 *
 * @author Brennan Walsh
 * @email mail@brennanwal.sh
 * @github https://github.com/iambrennanwalsh
 */
abstract class AbstractMailer
{
    const FROM_ADDRESS = "mail@todone.local";

    const TO_ADDRESS = "mail@brennanwal.sh";

    protected $twig;

    protected $mailer;

    private $env;

    /**
     * The subject for the email.
     * @var string
     */
    private $subject;

    /**
     * The path (relative to /template) to the template used to render the email.
     * @var string
     */
    private $template;

    /**
     * An array of variables to pass into the twig template.
     * @var array
     */
    private $content;

    /**
     * The recipent of this email.
     * @var string
     */
    private $to;

    /**
     * The sender of this email.
     * @var string
     */
    private $from;

    public function __construct($env, Environment $twig, \Swift_Mailer $mailer)
    {
        $this->twig = $twig;
        $this->mailer = $mailer;
        $this->from = self::FROM_ADDRESS;
        $this->env = $env;
        $this->to = self::TO_ADDRESS;
    }

    abstract protected function send();

    protected function setSubject(string $subject)
    {
        $this->subject = $subject;
    }

    protected function getSubject(): ?string
    {
        return $this->subject;
    }

    protected function setTemplate(string $template)
    {
        $this->template = $template;
    }

    protected function getTemplate(): ?string
    {
        return $this->template;
    }

    protected function setContent(array $content)
    {
        $this->content = $content;
    }

    protected function getContent(): ?array
    {
        return $this->content;
    }

    protected function setTo(string $to)
    {
        if ($this->env != "dev") {
            $this->to = $to;
        }
    }

    protected function getTo(): string
    {
        return $this->to;
    }

    protected function setFrom(string $from)
    {
        $this->from = $from;
    }

    protected function getFrom(): string
    {
        return $this->from;
    }
}
