<?php

declare(strict_types=1);

namespace Datana\Zammad\Api;

use Datana\Zammad\Api\Domain\Value\Ticket;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class TicketsApi implements TicketsApiInterface
{
    public function __construct(
        private HttpClientInterface $zammadApi,
        private LoggerInterface $logger,
    ) {
    }

    public function create(Ticket $ticket): void
    {
        try {
            $this->zammadApi->request(
                Request::METHOD_POST,
                '/api/v1/tickets',
                [
                    'json' => $ticket->toArray(),
                ],
            );
        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage());

            throw $e;
        }
    }
}
