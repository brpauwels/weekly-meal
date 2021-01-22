<?php

declare(strict_types=1);

namespace App\Infrastructure\Shared\Bus;

use App\Application\Query\Query;
use App\Application\Query\QueryBus;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\Exception\LogicException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Throwable;

use function array_map;
use function count;
use function get_debug_type;
use function implode;
use function sprintf;

final class MessengerQueryBus implements QueryBus
{
    use HandlerFailedExceptionConverter;

    private MessageBusInterface $messageBus;

    public function __construct(MessageBusInterface $queryBus)
    {
        $this->messageBus = $queryBus;
    }

    /**
     * @throws Throwable
     */
    public function dispatch(Query $query): mixed
    {
        try {
            $envelope = $this->messageBus->dispatch($query);
        } catch (HandlerFailedException $exception) {
            $this->convertHandlerFailedException($exception);
        }

        /** @var HandledStamp[] $handledStamps */
        $handledStamps = $envelope->all(HandledStamp::class);

        if (! $handledStamps) {
            throw new LogicException(
                sprintf(
                    'Message of type "%s" was handled zero times. Exactly one handler is expected when using "%s::%s()".',
                    get_debug_type($envelope->getMessage()),
                    static::class,
                    __FUNCTION__
                )
            );
        }

        if (count($handledStamps) > 1) {
            $handlers = implode(
                ', ',
                array_map(
                    static function (HandledStamp $stamp): string {
                        return sprintf('"%s"', $stamp->getHandlerName());
                    },
                    $handledStamps
                )
            );

            throw new LogicException(
                sprintf(
                    'Message of type "%s" was handled multiple times. Only one handler is expected when using "%s::%s()", got %d: %s.',
                    get_debug_type($envelope->getMessage()),
                    static::class,
                    __FUNCTION__,
                    count($handledStamps),
                    $handlers
                )
            );
        }

        return $handledStamps[0]->getResult();
    }
}
