<?php

namespace Yosmy;

use Yosmy\Mongo;

class BaseEvent extends Mongo\Document implements Event
{
    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->offsetGet('_id');
    }

    /**
     * @return array
     */
    public function getLabels(): array
    {
        return $this->offsetGet('labels');
    }

    /**
     * @return array
     */
    public function getInvolved(): array
    {
        return $this->offsetGet('involved');
    }

    /**
     * @return array
     */
    public function getExtra(): array
    {
        return $this->offsetGet('extra');
    }

    /**
     * @return int
     */
    public function getDate(): int
    {
        return $this->offsetGet('date');
    }

    /**
     * {@inheritdoc}
     */
    public function bsonUnserialize(array $data)
    {
        /** @var Mongo\DateTime $start */
        $date = $data['date'];
        $data['date'] = $date->toDateTime()->getTimestamp();

        parent::bsonUnserialize($data);
    }

    /**
     * {@inheritDoc}
     */
    public function jsonSerialize(): object
    {
        $data = parent::jsonSerialize();

        $data->id = $data->_id;

        unset($data->_id);

        return $data;
    }
}
