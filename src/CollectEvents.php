<?php

namespace Yosmy;

use Yosmy\Mongo;

/**
 * @di\service()
 */
class CollectEvents
{
    /**
     * @var Mongo\PrepareArrayCriteria
     */
    private $prepareArrayCriteria;

    /**
     * @var ManageEventCollection
     */
    private $manageCollection;

    /**
     * @param Mongo\PrepareArrayCriteria $prepareArrayCriteria
     * @param ManageEventCollection      $manageCollection
     */
    public function __construct(
        Mongo\PrepareArrayCriteria $prepareArrayCriteria,
        ManageEventCollection $manageCollection
    ) {
        $this->prepareArrayCriteria = $prepareArrayCriteria;
        $this->manageCollection = $manageCollection;
    }

    /**
     * @param array|null $labels
     * @param array|null $involved
     * @param array|null $extra
     * @param int|null   $from
     * @param int|null   $to
     * @param int|null   $skip
     * @param int|null   $limit
     *
     * @return Events
     */
    public function collect(
        ?array $labels,
        ?array $involved,
        ?array $extra,
        ?int $from,
        ?int $to,
        ?int $skip,
        ?int $limit
    ): Events {
        $criteria = $this->build(
            $labels,
            $involved,
            $extra,
            $from,
            $to
        );

        $options = [];

        if ($skip !== null) {
            $options['skip'] = $skip;
        }

        if ($limit !== null) {
            $options['limit'] = $limit;
        }

        $options['sort'] = [
            'date' => -1,
            '_id' => -1,
        ];

        $cursor = $this->manageCollection->find(
            $criteria,
            $options
        );

        return new Events($cursor);
    }

    /**
     * @param array|null $labels
     * @param array|null $involved
     * @param array|null $extra
     * @param int|null   $from
     * @param int|null   $to
     *
     * @return int
     */
    public function count(
        ?array $labels,
        ?array $involved,
        ?array $extra,
        ?int $from,
        ?int $to
    ): int {
        $criteria = $this->build(
            $labels,
            $involved,
            $extra,
            $from,
            $to
        );

        return $this->manageCollection->count(
            $criteria
        );
    }

    /**
     * @param array|null $labels
     * @param array|null $involved
     * @param array|null $extra
     * @param int|null   $from
     * @param int|null   $to
     *
     * @return array
     */
    private function build(
        ?array $labels,
        ?array $involved,
        ?array $extra,
        ?int $from,
        ?int $to
    ): array {
        $criteria = [];

        if ($labels !== null) {
            $criteria['labels'] = ['$in' => $labels];
        }

        if ($involved !== null) {
            $criteria = array_merge(
                $criteria,
                $this->prepareArrayCriteria->prepare(
                    'involved',
                    $involved
                )
            );
        }

        if ($extra !== null) {
            $criteria['extra'] = $extra;
        }

        if ($from !== null) {
            $criteria['date']['$gte'] = new Mongo\DateTime($from * 1000);
        }

        if ($to !== null) {
            $criteria['date']['$lt'] = new Mongo\Datetime($to * 1000);
        }

        return $criteria;
    }
}
