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
use OskarStark\Value\TrimmedNonEmptyString;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;

final class TicketsApi implements TicketsApiInterface
{
    public function __construct(
        private ZammadClient $client,
        private LoggerInterface $logger,
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function search(string $searchterm, ?int $page = null, ?int $objectsPerPage = null): array
    {
        $this->logger->debug('Searching for tickets', ['searchterm' => $searchterm]);

        $parameters = [
            'expand' => true,
            'query' => TrimmedNonEmptyString::fromString($searchterm)->toString(),
        ];

        if (null !== $page && null !== $objectsPerPage) {
            $parameters['page'] = $page;
            $parameters['per_page'] = $objectsPerPage;
        } elseif (null === $page) {
            throw new \InvalidArgumentException('page parameter must be set if objectsPerPage parameter is set');
        } elseif (null === $objectsPerPage) {
            throw new \InvalidArgumentException('objectsPerPage parameter must be set if page parameter is set');
        }

        try {
            $response = $this->client->request(
                Request::METHOD_GET,
                '/api/v1/tickets/search',
                [
                    'query' => $parameters,
                ],
            );

            $this->logger->debug('Response', $response->toArray(false));

            return $response->toArray();
        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage());

            throw $e;
        }
    }

    public function create(Ticket $ticket): bool
    {
        try {
            $response = $this->client->request(
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
