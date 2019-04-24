<?php

namespace Yosmy;

use Yosmy\Mongo;

class Events extends Mongo\Collection
{
    /**
     * @var Event[]
     */
    protected $cursor;
}

