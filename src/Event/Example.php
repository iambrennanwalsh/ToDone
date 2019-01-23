<?php

namespace App\Event;

use Symfony\Component\EventDispatcher\Event;

class Example extends Event
{
    private $who;
    private $what;
    private $when;

    public function __construct($who, $what)
    {
        $this->who = $who;
        $this->what = $what;
        $this->when = new \DateTime();
    }

    public function who()
    {
        return $this->who;
    }

    public function what()
    {
        return $this->what;
    }

    public function when()
    {
        return $this->when;
    }
}