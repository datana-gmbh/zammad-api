<?php

declare(strict_types=1);

namespace Datana\Zammad\Api;


use Datana\Zammad\Api\Domain\Value\Ticket;

final class NullTicketsApi implements TicketsApiInterface
{
    public function create(Ticket $ticket): void
    {
    }
}
