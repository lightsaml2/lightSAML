<?php

/*
 * This file is part of the LightSAML-Core package.
 *
 * (c) Milos Tomic <tmilos@lightsaml.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace LightSaml\Binding;

use LightSaml\Context\Profile\MessageContext;
use LightSaml\Event\BindingMessageReceived;
use LightSaml\Event\BindingMessageSent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;

abstract class AbstractBinding
{
    /** @var EventDispatcherInterface|null */
    protected $eventDispatcher;

    /**
     * @return AbstractBinding
     */
    public function setEventDispatcher(EventDispatcherInterface $eventDispatcher = null)
    {
        $this->eventDispatcher = $eventDispatcher;

        return $this;
    }

    /**
     * @return \Symfony\Component\EventDispatcher\EventDispatcherInterface|null
     */
    public function getEventDispatcher()
    {
        return $this->eventDispatcher;
    }

    /**
     * @param string $messageString
     */
    protected function dispatchReceive($messageString)
    {
        if ($this->eventDispatcher) {
            $this->eventDispatcher->dispatch(new BindingMessageReceived($messageString));
        }
    }

    /**
     * @param string $messageString
     */
    protected function dispatchSend($messageString)
    {
        if ($this->eventDispatcher) {
            $this->eventDispatcher->dispatch(new BindingMessageSent($messageString));
        }
    }

    /**
     * @param string|null $destination
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    abstract public function send(MessageContext $context, $destination = null);

    abstract public function receive(Request $request, MessageContext $context);
}
