<?php

declare(strict_types=1);

namespace App\Infrastructure\Shared\EventSauce;

use EventSauce\EventSourcing\Message;
use EventSauce\EventSourcing\MessageDispatcher;
use EventSauce\EventSourcing\SynchronousMessageDispatcher;

final class TaggedMessageDispatcher implements MessageDispatcher
{
    private MessageDispatcher $messageDispatcher;

    public function __construct(iterable $consumers)
    {
        $this->messageDispatcher = new SynchronousMessageDispatcher(... $consumers);
    }

    public function dispatch(Message ...$messages)
    {
        $this->messageDispatcher->dispatch(... $messages);
    }

}
