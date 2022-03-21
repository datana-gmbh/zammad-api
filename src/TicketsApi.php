<?php

declare(strict_types=1);

/*
 * This file is part of Zammad-Api.
 *
 * (c) Datana GmbH <info@datana.rocks>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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

    public function create(Ticket $ticket): bool
    {
        try {
            $response = $this->zammadApi->request(
                Request::METHOD_POST,
                '/api/v1/tickets',
                [
                    'json' => $ticket->toArray(),
                ],
            );

            $this->logger->debug('Response', $response->toArray(false));

            if (!\in_array($response->getStatusCode(), [200, 201], true)) {
                return false;
            }

            return true;
        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage());

            throw $e;
        }
    }
}
