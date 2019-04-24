<?php

namespace Yosmy;

use Yosmy\Mongo;

/**
 * @di\service()
 */
class BaseLogEvent
{
    /**
     * @var ManageEventCollection
     */
    private $manageCollection;

    /**
     * @param ManageEventCollection $manageCollection
     */
    public function __construct(
        ManageEventCollection $manageCollection
    ) {
        $this->manageCollection = $manageCollection;
    }

    /**
     * @param array $labels
     * @param array  $involved
     * @param array  $extra
     *
     * @return string
     */
    public function log(
        array $labels,
        array $involved,
        array $extra
    ): string {
        $id = uniqid();

        $this->manageCollection->insertOne([
            '_id' => $id,
            'labels' => $labels,
            'involved' => $involved,
            'extra' => $extra,
            'date' => new Mongo\DateTime(time() * 1000),
        ]);

        return $id;
    }
}