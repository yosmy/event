<?php

namespace Yosmy;

interface Event
{
    /**
     * @return string
     */
    public function getId(): string;

    /**
     * @return array
     */
    public function getLabels(): array;

    /**
     * @return array
     */
    public function getInvolved(): array;

    /**
     * @return array
     */
    public function getExtra(): array;

    /**
     * @return int
     */
    public function getDate(): int;
}
