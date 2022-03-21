# zammad-api

| Branch    | PHP                                         | Code Coverage                                        |
|-----------|---------------------------------------------|------------------------------------------------------|
| `master`  | [![PHP][build-status-master-php]][actions]  | [![Code Coverage][coverage-status-master]][codecov]  |

## Usage

### Installation

```bash
composer require datana-gmbh/zammad-api
```

### Setup

```php
use Datana\Zammad\Api\ZammadClient;

$baseUri = 'https://api.zammad...';
$token = '...';

$client = new ZammadClient($baseUri, $token);

// you can now request any endpoint which needs authentication
$client->request('GET', '/api/something', $options);
```

## Tickets

In your code you should type-hint to `Datana\Zammad\Api\TicketsApiInterface`

### Create a ticket

```php
use Datana\Zammad\Api\TicketsApi;
use Datana\Zammad\Api\ZammadClient;

$client = new ZammadClient(/* ... */);

$ticketsApi = new TicketsApi($client);

$ticket = new Ticket(/* ... */);
$ticketsApi->create($ticket);
```

[build-status-master-php]: https://github.com/datana-gmbh/zammad-api/workflows/PHP/badge.svg?branch=master
[coverage-status-master]: https://codecov.io/gh/datana-gmbh/zammad-api/branch/master/graph/badge.svg

[actions]: https://github.com/datana-gmbh/zammad-api/actions
[codecov]: https://codecov.io/gh/datana-gmbh/zammad-api
