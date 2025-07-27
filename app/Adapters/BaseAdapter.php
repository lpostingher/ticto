<?php

namespace App\Adapters;

use GuzzleHttp\Client;

/**
 * @property Client $client
 */
class BaseAdapter
{
    public function __construct(protected readonly Client $client)
    {
    }
}
