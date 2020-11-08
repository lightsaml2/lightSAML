<?php

namespace LightSaml\Event;

use Symfony\Contracts\EventDispatcher\Event;

class BindingMessageSent extends Event
{
    protected $messageString;

    public function __construct(string $messageString)
    {
        $this->messageString = $messageString;
    }

    public function getMessageString() : string
    {
        return $this->messageString;
    }
}