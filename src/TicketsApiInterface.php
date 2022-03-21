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

interface TicketsApiInterface
{
    public function create(Ticket $ticket): void;
}
