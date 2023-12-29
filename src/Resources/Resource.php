<?php

namespace Blueskyci\PointClickCare\Resources;

abstract class Resource {
    protected $client;

    public function __construct($client)
    {
        $this->client = $client;
    }

}