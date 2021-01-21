<?php

declare(strict_types=1);

namespace App\Infrastructure\Shared\Bus;

use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Throwable;

use function assert;

trait HandlerFailedExceptionConverter
{
    /**
     * @throws Throwable
     */
    public function convertHandlerFailedException(HandlerFailedException $exception): void
    {
        while ($exception instanceof HandlerFailedException) {
            $exception = $exception->getPrevious();
            assert($exception instanceof Throwable);
        }

        throw $exception;
    }
}
