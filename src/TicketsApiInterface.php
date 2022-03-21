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
    public function create(Ticket $ticket): bool;

    /**
     * @param string  $searchterm The searchterm to search for.
     * @param null|int $page                 Page of objects, optional, if given, $objects_per_page must also be given.
     * @param null|int $objectsPerPage     Number of objects per page, optional, if given, $page must also be given.
     */
    public function search(string $searchterm, ?int $page = null, ?int $objectsPerPage = null): array;

