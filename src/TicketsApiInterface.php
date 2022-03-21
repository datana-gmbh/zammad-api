<?php

declare(strict_types=1);

namespace Datana\Zammad\Api;

use Datana\Zammad\Api\Domain\Value\Ticket;

interface TicketsApiInterface
{
    public function create(Ticket $ticket): void;
}
